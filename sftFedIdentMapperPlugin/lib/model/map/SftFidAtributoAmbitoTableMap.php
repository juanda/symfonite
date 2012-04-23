<?php


/**
 * This class defines the structure of the 'sft_fid_atributo_ambito' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Mon Apr 23 08:11:19 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sftFedIdentMapperPlugin.lib.model.map
 */
class SftFidAtributoAmbitoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sftFedIdentMapperPlugin.lib.model.map.SftFidAtributoAmbitoTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('sft_fid_atributo_ambito');
		$this->setPhpName('SftFidAtributoAmbito');
		$this->setClassname('SftFidAtributoAmbito');
		$this->setPackage('plugins.sftFedIdentMapperPlugin.lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ID_ATRIBUTO', 'IdAtributo', 'INTEGER' , 'sft_fid_atributos', 'ID', true, null, null);
		$this->addPrimaryKey('ID_AMBITO', 'IdAmbito', 'INTEGER', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SftFidAtributo', 'SftFidAtributo', RelationMap::MANY_TO_ONE, array('id_atributo' => 'id', ), 'CASCADE', 'CASCADE');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SftFidAtributoAmbitoTableMap
