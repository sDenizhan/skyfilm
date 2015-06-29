<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Administrator Class
 *
 * @author Süleyman DENİZHAN
 * @package CodeIgniter
 *
 */

class Auth {

    private $CI;
    private $admin_table = 'yoneticiler';
    private $hash_repeat = 5;

    private $permission = array();

    /**
     *
     * Hataları Tutacak Değişken
     *
     * @var array
     */
    public $error = null;

    function __construct() {
        //super değişken
        $this->CI =& get_instance();

        //oturum classı yükleniyor...
        $this->CI->load->library( array('session') );

        $this->CI->load->database();
    }

    function get_table()
    {
        return $this->admin_table;
    }

    function set_table($table)
    {
        if ( !empty($table) || $table != NULL )
        {
            $this->admin_table = $table;
        }
    }

    function admin_login($user, $pass)
    {
        //kullanıcı adı veya şifresi boş ise
        if ( empty($user) || empty($pass) )
        {
            $this->error = 'Kullanıcı Adını veya Şifresini Girmelisiniz..!';
            return false;
        }

        //user array
        $where_array = array('kullanici_adi' => $user, 'sifre' => $this->do_hash($pass));

        //kullanıcı var mı
        $query = $this->CI->db->get_where($this->admin_table, $where_array);

        //kullanıcı varsa
        if ( $query->num_rows() > 0 )
        {
            //durum kontrolü
            if ( $query->row()->durum != 'aktif')
            {
                $this->error = 'Aktif Olmayan Yönetici Hesabı İle Giremezsiniz..!';
                return false;
            }
            else
            {
                //yönetici sessionları ekleyelim
                $sessions = array(
                    'girenKim' => 'Admin|Yonetici|Birileri|İste',
                    'admin' => $query->row(),
                    'izinler' => $this->izinler( $query->row()->id )
                );

                $this->add_sessions($sessions);

                //son girişi güncelleyelim
                $this->CI->db->update($this->admin_table, array('son_giris' => time()), array('id' => $query->row()->id) );

                //true döndürüp admin girdiğini belirtelim
                return true;

            }

        }
        else
        {
            $this->error = 'Kullanıcı Bulunamadı..!';
            return false;
        }


    }

    function login_control()
    {
        if ( $this->CI->session->userdata('girenKim') != 'Admin|Yonetici|Birileri|İste')
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function do_hash( $pass, $repeat = NULL )
    {
        if ( empty($pass))
        {
            return false;
        }

        //eğer tekrarlama kapalı ise 1 kere,
        //açık ise $repeat kadar döngü dönsün
        $repeat = ( $repeat == NULL ) ? $this->hash_repeat : $repeat;

        //md5'e key ekleyerek hackerların işlerini zorlaştıralım
        $key = '<<<SüleymanDenizhan|TeaForFreelancer>>>';

        //hashleme başlıyor
        for ( $i = 0; $i <= $repeat; $i++ )
        {
            $pass = md5(sha1($pass.$key).$key);
        }

        return $pass;
    }

    function add_sessions( $ses = array() )
    {
        if ( ! is_array($ses) || count($ses) <= 0 )
        {
            return false;
        }

        $this->CI->session->set_userdata( $ses );
    }

    function display_errors()
    {
        if ( $this->error != null )
        {
            return $this->error;
        }
        else
        {
            return '';
        }
    }

    public function cikis_yap($redirect = false, $url = null) {

        //session'ları sildik...
        $this->CI->session->sess_destroy();

        //yönlendirme yaptık...
        if ( $redirect != false && $url != null )
        {
            redirect($url);
        }
        else
        {
            redirect(base_url());
        }

    }

    public function izinler( $grup_id = null )
    {
        if ( $grup_id == null )
        {
            log_message('error', 'Kullanıcı Grubu Bulunamadı..!');
            return false;
        }

        $get = $this->CI->db->get_where('gruplar', array('id' => $grup_id));

        if ( $get->num_rows() > 0 )
        {
            $izinler = explode(',', base64_decode($get->row()->izinler));

            foreach($izinler as $izin)
            {
                $this->permission[$izin] = true;
            }

            return $this->permission;
        }
        else
        {
            log_message('error', 'İzinler Bulunamadı..!');
        }

    }

    public function izin_kontrol( $izin )
    {
        if ( empty($izin) )
            return false;

        $izinler = $this->CI->session->userdata('izinler');

        if ( isset($izinler[$izin]) )
        {
            return ( $izinler[$izin] == true ) ? true : false;
        }
        else
        {
            return false;
        }

    }
}
?>