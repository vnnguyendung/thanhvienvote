<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Thanhvienvote
 * @author     vnnguyendung <vnnguyendung@gmail.com>
 * @copyright  GigaViNa
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Thanhvienvote', JPATH_COMPONENT);
JLoader::register('ThanhvienvoteController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Thanhvienvote');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
