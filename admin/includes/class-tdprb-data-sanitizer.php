<?php

/**
 * Class TDPRB_DynamicDataSanitizer
 *
 * Provides methods to sanitize various types of data, including strings, integers, booleans, and arrays.
 */
class TDPRB_DynamicDataSanitizer {

    /**
     * Sanitize the given data based on its type.
     *
     * @param mixed $data The data to sanitize.
     * @return mixed The sanitized data.
     */
    public function sanitize($data) {
        // Check the type of data and apply appropriate sanitization
        if (is_string($data)) {
            // Check if the string is a URL
            if (filter_var($data, FILTER_VALIDATE_URL)) {
                return esc_url_raw($data);
            }
            return sanitize_text_field($data);
        } elseif (is_int($data)) {
            return intval($data);
        } elseif (is_bool($data)) {
            return filter_var($data, FILTER_VALIDATE_BOOLEAN);
        } elseif (is_array($data)) {
            return $this->sanitizeArray($data);
        } else {
            // Default sanitization for unsupported data types
            return sanitize_text_field($data);
        }
    }

    /**
     * Recursively sanitize an array and transform it based on specific requirements.
     *
     * @param array $data The data to sanitize.
     * @return array The sanitized data.
     */
    private function sanitizeArray(array $data) {
        $sanitized_data = [];
        foreach ($data as $key => $value) {
           
            // Sanitize the key
            $sanitized_key = sanitize_key($key);

            if (is_array($value)) {
                // Special case for 'search_filters' to restructure the data
                if ($sanitized_key === 'search_filters') {
                    foreach ($value as $filter) {
                        if (isset($filter)) {
                           //echo  $filter_key = sanitize_key($filter['key']);
                            $sanitized_data[$sanitized_key][] = [
                                'key'           => isset($filter['key'])            ? $this->sanitize($filter['key']) : '',
                                'text'          => isset($filter['text'])           ? $this->sanitize($filter['text']) : '',
                                'type'          => isset($filter['type'])           ? $this->sanitize($filter['type']) : '',
                                'status'        => isset($filter['status'])         ? $this->sanitize($filter['status']) : '',
                                'isSubItem'     => isset($filter['isSubItem'])      ? $this->sanitize($filter['isSubItem']) : '',
                                'advancefilter' => isset($filter['advancefilter'])  ? $this->sanitize($filter['advancefilter']) : '',
                                'items'         => isset($filter['items']) && is_array($filter['items']) ? $this->sanitizeArray($filter['items']) : [],
                            ];
                        }
                    }
                } else {
                  
                    // Recursively sanitize nested arrays
                    $sanitized_data[$sanitized_key] = $this->sanitizeArray($value);
                }
            } else {
               
                // Sanitize the value based on its type
                $sanitized_data[$sanitized_key] = $this->sanitize($value);
            }
        }

        return $sanitized_data;
    }
}