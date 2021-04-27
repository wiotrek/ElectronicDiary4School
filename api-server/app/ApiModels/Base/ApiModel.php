<?php


namespace App\ApiModels\Base;

/**
 * The base class of models to create response for called object models
 */
class ApiModel {

    /**
     * Response creator for api models
     */
    public function toString () {
        // Collect data to return variable
        $buildReturn = '{'."\n\t";

        // Get called child object
        $calledChildObject = static::class;

        // Get properties of called object
        $propertiesChildObject = get_class_vars($calledChildObject);

        // For each property...
        foreach ($propertiesChildObject as $propertyName => $value) {

            // Build json depend on property is object
            if (is_object($value))
                $buildReturn .= '"'.$propertyName.'": '.$value.''.','."\n\t";
            // or not
            else
                $buildReturn .= '"'.$propertyName.'": "'.$value.'"'.','."\n\t";

        }


        // Return collected data as json object
        return substr($buildReturn, 0, -3 )."\n".'}';
    }

}