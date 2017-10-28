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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_thanhvienvote'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Thanhvienvote', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('ThanhvienvoteHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'thanhvienvote.php');

$controller = JControllerLegacy::getInstance('Thanhvienvote');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
