<?
class email_model extends CI_Model
{
	
	function __construct()
	{
		
	}
	
        //to get email body and subject
        function get_email_template($mail_type)
        {
                $options=array('email_code'=>$mail_type);
                $query=$this->db->get_where('email_settings',$options);

                return $query->row_array();
        }

        //to parse the the email which is available in the
        function parse_email($parseElement,$mail_body)
        {
                foreach($parseElement as $name=>$value)
                {
                        $parserName=$name;
                        $parseValue=$value;
                        $mail_body=str_replace("[$parserName]",$parseValue,$mail_body);
                }
                return $mail_body;
        }
		
}
?>