<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Lang extends CI_Lang {

	/**
	 * Load a language file
	 *
	 * @access	public
	 * @param	mixed	the name of the language file to be loaded. Can be an array
	 * @param	string	the language (english, etc.)
	 * @param	bool	return loaded array of translations
	 * @param 	bool	add suffix to $langfile
	 * @param 	string	alternative path to look for language file
	 * @return	mixed
	 */
	function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
	{
		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix == TRUE)
		{
			$langfile = str_replace('_lang.', '', $langfile).'_lang';
		}

		$langfile .= '.php';

		if (in_array($langfile, $this->is_loaded, TRUE))
		{
			return;
		}

		$config =& get_config();

		if ($idiom == '')
		{
			$deft_lang = ( ! isset($config['language'])) ? 'english' : $config['language'];
			$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		}

		// Determine where the language file is and load it
		if ($alt_path != '' && file_exists($alt_path.'language/'.$idiom.'/'.$langfile))
		{
			include($alt_path.'language/'.$idiom.'/'.$langfile);
		}
		else
		{
			$found = FALSE;

			foreach (get_instance()->load->get_package_paths(TRUE) as $package_path)
			{
				if (file_exists($package_path.'language/'.$idiom.'/'.$langfile))
				{
					include($package_path.'language/'.$idiom.'/'.$langfile);
					$found = TRUE;
					break;
				}
			}
			
			
			if ($found == FALSE) {
				$database_lang =  $this->_get_from_db($idiom);
                if (!empty($database_lang)){
					$lang = $database_lang;	
					$found = TRUE;
				}
			}

			if ($found !== TRUE)
			{
				show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile);
			}
		}


		if ( ! isset($lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);
			return;
		}

		if ($return == TRUE)
		{
			return $lang;
		}

		$this->is_loaded[] = $langfile;
		$this->language = array_merge($this->language, $lang);
		unset($lang);

		log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}
	
    /**
     * Load a language from database
     *
     * @access    private
     * @return    array
     */
    private function _get_from_db($idiom)
    {
        $CI =& get_instance();

		$query = $CI->db->query(";WITH CTE (LanguageKey, Data) AS (
			SELECT
				Election_Language.LanguageKey,
				Election_Language.Data AS Data
			FROM
				Election_Language
				INNER JOIN Election_LanguageCode ON Election_Language.LanguageCodeId = Election_LanguageCode.Id
			WHERE
				Election_LanguageCode.Code = '" .  $idiom . "'
			)
			SELECT
				CTE.LanguageKey,
				CTE.Data
			FROM
				CTE

			UNION

			SELECT
				Election_Language.LanguageKey,
				Election_Language.Data AS Data
			FROM
				Election_Language
				INNER JOIN Election_LanguageCode ON Election_Language.LanguageCodeId = Election_LanguageCode.Id
			WHERE
				Election_LanguageCode.Code = 'en'
				AND NOT EXISTS (SELECT 1 FROM CTE WHERE CTE.LanguageKey = Election_Language.LanguageKey);");
		
        foreach ($query->result() as $row)
        {
            $return[$row->LanguageKey] = $row->Data;
        }

        unset($CI, $query);
        return $return;
    }	
}