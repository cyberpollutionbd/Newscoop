<?php
/**
 * @package Campsite
 */

/**
 * Includes
 */
// We indirectly reference the DOCUMENT_ROOT so we can enable
// scripts to use this file from the command line, $_SERVER['DOCUMENT_ROOT']
// is not defined in these cases.
$g_documentRoot = $_SERVER['DOCUMENT_ROOT'];

require_once($g_documentRoot.'/classes/Template.php');
require_once($g_documentRoot.'/template_engine/metaclasses/MetaDbObject.php');

/**
 * @package Campsite
 */
final class MetaTemplate extends MetaDbObject {

    public function __construct($p_templateIdOrName = null)
    {
        $this->m_dbObject = new Template($p_templateIdOrName);
        if (!$this->m_dbObject->exists()) {
            $this->m_dbObject = new Template();
        }

        $this->m_properties['name'] = 'Name';
        $this->m_properties['identifier'] = 'Id';

		$this->m_customProperties['type'] = 'getTemplateType';
        $this->m_customProperties['defined'] = 'defined';
    } // fn __construct


    protected function getTemplateType()
    {
    	global $g_ado_db;

    	$templateTypeId = $this->m_dbObject->getType();
    	$query = "SELECT Name FROM TemplateTypes WHERE Id = $templateTypeId";
    	return $g_ado_db->GetOne($query);
    }


    protected function getValue()
    {
        return $this->m_dbObject->getName();
    }


    public function IsValid($p_value)
    {
        $template = new Template($p_value);
        return $template->exists();
    }


    public static function GetTypeName()
    {
        return 'template';
    }
} // class MetaTemplate

?>