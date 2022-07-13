<?php

    // FOR CLEAN URL

    namespace CT;

    class Clean_url {

        public function cleaner($url = null, $regexCleaner = null){
            if ($url !== null && $regexCleaner !== null) {
                $clean_url = preg_replace($regexCleaner, '', strtolower($url));
                return $clean_url;
            } else {
                return null;
            }
        }
        
    }