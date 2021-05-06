<?php


namespace App\Serialization\JsonBuilder\Parts;


use App\Serialization\JsonBuilder\JsonBuilderInterface;

/**
 * The json converter for api models
 */
class JsonObject implements JsonBuilderInterface {

    /**
     * Response creator for api models
     */
    public function createJsonObject () {
        // Collect data to json style
        $jsonPart = '{'."\n\t";

        // Get called child object
        $calledChildObject = static::class;

        // Get properties of called object
        $propertiesChildObject = get_class_vars($calledChildObject);

        // For each property...
        foreach ($propertiesChildObject as $propertyName => $value) {

            // Build json depend on property is object, array or something else
            if (!is_object($value) && !is_array($value) && !is_null($value))
                $jsonPart .= '"' . $propertyName . '": '. '"' . $value . '"' . ',' . "\n\t";
            else if ( is_object( $value ) )
                $jsonPart .= '"' . $propertyName . '": ' . $value . '' . ',' . "\n\t";
            else if (is_array( $value )) {
                $jsonPart .= '"' . $propertyName . '"' . ': [' . "\n\t" . self :: createNestedJsonObject( $value ) . "\n\t" . '],';
            }

        }

        // Return collected data as json object
        return substr($jsonPart, 0, -3 )."\n".'}';
    }

    // Build nested objects as model in another model
    public function createNestedJsonObject ( $value ): string {

        $jsonFragment = '';

        foreach ( $value as $item => $val ) {
            if (!is_array($val)) {
                $jsonFragment .= $val . ',';
            }
        }

        // Return fragment collected data as json object
        return substr($jsonFragment, 0, -3 );
    }
}
