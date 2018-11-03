<!-- BEGIN PhpHeader --><?php

/**
 * Class {ClassName}
 * Entity class for object oriented management of the MySQL table {TableName}
 *
 * @extends {ClassParent}
 * @category Entity Class
*/

class {ClassName} extends {ClassParent}
{
<!-- END PhpHeader -->
<!-- BEGIN PkAttribute -->
    /**
     * Class attribute for mapping the primary key {TablePkName} of table {TableName}
     *
     * Comment for field {TablePkName}: {Comment}<br>
     * @var {ClassPkAttributeType} ${ClassPkAttributeName}
     */
    protected ${ClassPkAttributeName};
<!-- END PkAttribute -->
<!-- BEGIN Attributes -->
    /**
     * Class attribute for mapping table field {TableFieldName} defined as {TableFieldTypeAndLenght}
     *
     * @var {ClassAttributeType} ${ClassAttributeName}
     */
    protected ${ClassAttributeName};
<!-- END Attributes -->
<!-- BEGIN Setters -->
    /**
     * {SetterMethod} Sets the class attribute {ClassAttributeName} with a given value
     *
     * @param {ClassAttributeType} ${ClassAttributeName}
     */
    public function {SetterMethod}(${ClassAttributeName})
    {
        $this->{ClassAttributeName} = {Cast}${ClassAttributeName};
    }
<!-- END Setters -->
<!-- BEGIN Getters -->
    /**
     * {GetterMethod} gets the class attribute {ClassAttributeName} value
     *
     * @return {ClassAttributeType} ${ClassAttributeName}
     */
    public function {GetterMethod}()
    {
        return $this->{ClassAttributeName};
    }
<!-- END Getters -->
<!-- BEGIN PhpFooter -->
}
?>
<!-- END PhpFooter -->