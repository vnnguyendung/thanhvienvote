<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Thanhvienvote
 * @author     vnnguyendung <vnnguyendung@gmail.com>
 * @copyright  GigaViNa
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Votes list controller class.
 *
 * @since  1.6
 */
class ThanhvienvoteControllerVotes extends ThanhvienvoteController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Votes', $prefix = 'ThanhvienvoteModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
