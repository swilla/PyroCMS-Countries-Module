<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Countries model
*
 * @author Steve Williamson
 * @link http://appsygna.com/
 */
class Country_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();

        $this->_table = 'countries';
    }

    public function search($data = array())
    {
        if (array_key_exists('keywords', $data))
        {
            $matches = array();
            if (strstr($data['keywords'], '%'))
            {
                preg_match_all('/%.*?%/i', $data['keywords'], $matches);
            }

            if (!empty($matches[0]))
            {
                foreach ($matches[0] as $match)
                {
                    $phrases[] = str_replace('%', '', $match);
                }
            }
            else
            {
                $temp_phrases = explode(' ', $data['keywords']);
                foreach ($temp_phrases as $phrase)
                {
                    $phrases[] = str_replace('%', '', $phrase);
                }
            }

            $counter = 0;
            foreach ($phrases as $phrase)
            {
                if ($counter == 0)
                {
                    $this->db->like('code', $phrase);
                }
                else
                {
                    $this->db->or_like('code', $phrase);
                }

                $this->db->or_like('country', $phrase);
                $counter++;
            }
        }

        return $this->get_all();
    }
}
