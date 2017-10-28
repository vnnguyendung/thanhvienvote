<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Thanhvienvote
 * @author     vnnguyendung <vnnguyendung@gmail.com>
 * @copyright  GigaViNa
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_thanhvienvote', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_thanhvienvote/js/form.js');

$user    = JFactory::getUser();
$canEdit = ThanhvienvoteHelpersThanhvienvote::canUserEdit($this->item, $user);


?>

<div class="vote-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_THANHVIENVOTE_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_THANHVIENVOTE_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_THANHVIENVOTE_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-vote"
			  action="<?php echo JRoute::_('index.php?option=com_thanhvienvote&task=vote.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<?php echo $this->form->renderField('created_by'); ?>

	<?php echo $this->form->renderField('art_createdby'); ?>

	<?php echo $this->form->renderField('art_id'); ?>

	<?php echo $this->form->renderField('vote'); ?>

	<?php echo $this->form->renderField('save'); ?>

	<?php echo $this->form->renderField('time'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_thanhvienvote&task=voteform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_thanhvienvote"/>
			<input type="hidden" name="task"
				   value="voteform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
