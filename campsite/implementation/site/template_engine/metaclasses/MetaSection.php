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

require_once($g_documentRoot.'/classes/Section.php');
require_once($g_documentRoot.'/template_engine/metaclasses/MetaDbObject.php');

/**
 * @package Campsite
 */
final class MetaSection extends MetaDbObject {
	private static $m_baseProperties = array(
	'name'=>'Name',
    'number'=>'Number',
    'description'=>'Description',
    'url_name'=>'ShortName'
	);
	
	private static $m_defaultCustomProperties = array(
	'template'=>'getTemplate',
    'publication'=>'getPublication',
    'issue'=>'getIssue',
    'language'=>'getLanguage',
    'defined'=>'defined'
	);


    public function __construct($p_publicationId = null, $p_issueNumber = null,
                                $p_languageId = null, $p_sectionNumber = null)
    {
    	$this->m_properties = self::$m_baseProperties;
    	$this->m_customProperties = self::$m_defaultCustomProperties;

		$this->m_dbObject = new Section($p_publicationId, $p_issueNumber,
										$p_languageId, $p_sectionNumber);
        if (!$this->m_dbObject->exists()) {
            $this->m_dbObject = new Section();
        }
    } // fn __construct


    protected function getTemplate()
    {
    	if ($this->m_dbObject->getSectionTemplateId() > 0) {
   			return new MetaTemplate($this->m_dbObject->getSectionTemplateId());
    	}
    	$sectionIssue = new Issue($this->m_dbObject->getProperty('IdPublication'),
    							  $this->m_dbObject->getProperty('IdLanguage'),
    							  $this->m_dbObject->getProperty('NrIssue'));
   		return new MetaTemplate($sectionIssue->getSectionTemplateId());
    }


    protected function getPublication()
    {
        return new MetaPublication($this->m_dbObject->getPublicationId());
    }


    protected function getLanguage()
    {
        return new MetaLanguage($this->m_dbObject->getLanguageId());
    }


    protected function getIssue()
    {
        return new MetaIssue($this->m_dbObject->getPublicationId(),
                             $this->m_dbObject->getLanguageId(),
                             $this->m_dbObject->getIssueNumber());
    }

} // class MetaSection

?>