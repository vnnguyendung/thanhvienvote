<?php
/**
 * @copyright	Copyright (c) 2017 PlgThanhvienvote. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

jimport('joomla.plugin.plugin');

/**
 * content - thanhvienvote Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	PlgThanhvienvote.thanhvienvote
 * Huong dan su dung: them the tag {showthanhvienvote} vao cck content, intro de tao cac vote cho bai viet.
 */
class plgcontentthanhvienvote extends JPlugin {

   // protected $app;
    /**
     * Database object
     *
     * @var    JDatabaseDriver
     * @since  3.2
     */
    protected $db;
    
	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
    
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}
	
	
	/*id || user_act || user_own || art_id || vote || save || time
	 * Cho phep trong article detail thoi.
	 * Gioi han trong danh muc cho phep
	 * HIen thi tong so luot vote cua bai viet
	 * User chua vote lan nao, user da vote, user unvote, 
	 * 
	 * Phuong an. SQL toan bo cac value co cung art_id 
	 * Dem tong so cac vote column
	 * Xac dinh xem co user_act trong do hay khong, Neu co, vote la 0 hay 1.
	 * 
	 * Tao form, thay ten button cho phu hop
	 * Tao du lieu mau co cung art_id, khac nhau so vote (5)
	 * user_art chi 1 = 12, 
	 * 
	 */
	
	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{
	    // row: created_by id
	    $html = '';
	    $allowed_contexts = array('com_content.categories','com_content.category', 'com_content.article', 'com_content.featured');
	    
	    if (!in_array($context, $allowed_contexts))
	    {
	        return true;
	    }
	    
	    // Return if we don't have a valid article id
	    if (!isset($row->id) || !(int) $row->id)
	    {
	        return true;
	    }
	    
	    //$art_id = 12;
		   // $user_act = 54;
	    $art_id = $row->id;
	    $demsovote = $this->count_thanhvienvote_art_id($art_id);

	    $user  = JFactory::getUser();
	    
	    if ($user->id && (strpos($row->text, '{showthanhvienvote}') !== false)) {  
	        
	                
	   	    $user_act = $user->id;

		    $data_act      = $this->thanhvienvote_art_id_user_id($art_id,$user_act);
		    
		    $create_id     = is_null($data_act) ? '' : $data_act->id;
		    $create_art_createdby  = $row->created_by;
		    $create_art_id         = $art_id;
		    $create_date		= is_null($data_act) ? (JFactory::getDate()->toSql()) : $data_act->time;
		    
		    // khia nao bang 1, khi $data_act  = null, hoac $data_act->vote = 0
		    // bang 0 khi $data_act->vote = 0
		    if (is_null($data_act) ){
		         $create_vote           = 1;
		       } else {
		           $create_vote         = $data_act->vote ? '0' : '1';
		       }
		    
		    $create_save           = 0;
		    //$create_time
		    // neu vote data = 1, chuyen form_vote thanh gia tri nguoc lai
            $html .= $this->taoform($create_id,$create_art_id,$create_vote,$create_save,$create_art_createdby,$create_date);
	      }
	      
	  		$html .= 'Tong so Vote la: '. $demsovote;

	  		// Show thanhvienvote bang tag
	  		if (strpos($row->text, '{showthanhvienvote}') !== false) {
	  		    $row->text = str_replace('{showthanhvienvote}', $html , $row->text);
	  		}
	    
	}
	/* 
	 * Dem xem co bao nhieu nguoi da vote cho bai viet
	 *  */
	function count_thanhvienvote_art_id($art_id)
	{
	    $query = $this->db->getQuery(true);
	    
	    $query->select('COUNT(*)');
	    
	    $query->from($this->db->quoteName('#__thanhvienvote_vote','a'));
	    $query->where($this->db->quoteName('a.art_id') .' = ' . $this->db->quote($art_id));
	    $query->where($this->db->quoteName('a.vote') .' = ' . $this->db->quote('1'));
	    
	    $this->db->setQuery($query);
	    
	   return  $this->db->loadResult();
	}
	
	/* 
	 * Truy van thong tin ve user dang dang nhap tren CSDL
	 * Tim trong CSDL xem, tai article dang xem (art_id) co thong tin cua user dang xem hay khong (user_act)
	 * Khong co ket qua thi tra ve gia tri null
	 *  */
	
	function thanhvienvote_art_id_user_id($art_id,$user_act)
	{
	    $query = $this->db->getQuery(true);
	    
	    $query->select('*');
	    
	    $query->from($this->db->quoteName('#__thanhvienvote_vote','a'));
	    $query->where($this->db->quoteName('a.art_id') .' = ' . $this->db->quote($art_id));
	    $query->where($this->db->quoteName('a.created_by') .' = ' . $this->db->quote($user_act));
	    $this->db->setQuery($query);
	    
	    return  $this->db->loadObject();
	}
	
	// id  art_createdby  art_id   vote   save    time
	
	function taoform($create_id,$create_art_id,$create_vote,$create_save,$create_art_createdby,$create_date){
	    //$create_id,$create_art_id,$create_vote,$create_save
	  	$uri = clone JUri::getInstance();

	    $html ='';
	    $html .= '<form id="form-vote"
			  action="/ja380/create-form/vote/save"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
	        
	<input type="hidden" name="jform[id]" value="'.$create_id.'" />
	<input type="hidden" name="jform[art_createdby]" id="jform_art_createdby"  value="'.$create_art_createdby.'" class="required"     placeholder="Art Created by"   required aria-required="true"      />
	<input type="hidden" name="jform[art_id]" id="jform_art_id"  value="'.$create_art_id.'" class="required"     placeholder="Art Id"   required aria-required="true"      />
	<input type="hidden" name="jform[vote]" id="jform_vote"  value="'.$create_vote.'"      placeholder="Vote"         />
	<input type="hidden" name="jform[save]" id="jform_save"  value="'.$create_save.'"      placeholder="Save"         />
	<input type="hidden" name="jform[time]" value="'. $create_date .'" />
	';
	    $html .= $create_vote ?	'<button type="submit" class="validate btn btn-primary">+ VOTE</button>' : '<button type="submit" class="validate btn btn-warning">_ Del</button>';	
	$html .= '
	<input type="hidden" name="option" value="com_thanhvienvote"/>
	<input type="hidden" name="task"   value="voteform.save"/>';
		$html .= '<input type="hidden" name="return" value="'. htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8').'" />';
	    $html .= JHtml::_('form.token');
	    $html .='</form>';
	    
	    return $html;
	}
	
}


















