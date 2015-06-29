<?php
if (!defined('BASEPATH')) die('Hadi Başka Kapıya !!');

class Ayarlar {

    private $ci;

    private $table = 'ayarlar';

    public  $ayar_dizi = array();

    function __construct()
    {
        //super değişken
        $this->ci =& get_instance();

        //ayarları getirelim...
        if ( count($this->ayar_dizi) <= 0)
        {
            $this->get_ayarlar();
        }

    }

    function get_ayarlar()
    {
        //tüm ayarları çektik...
        $ayarlar = $this->ci->db->get($this->table);

        //ayarlar varsa...
        if ($ayarlar->num_rows() > 0)
        {
            //tüm ayarları ayarlar değişkenine işleyelim...
            foreach ($ayarlar->result() as $ayar)
            {
                $this->ayar_dizi[$ayar->ayar] = $ayar->deger;
            }

            //işlem bittiğin TRUE döndürelim..
            return TRUE;
        }
        //yoksa false döndürelim..
        else
        {
            return FALSE;
        }

    }

    /**
     * Ayarlar tablosundan istenilen ayarı getirir...
     *
     * @param string $ayaradi
     * @return string
     */

    function ayar_getir($ayaradi = '')
    {

        //ayar adı boşsa, boş değer dönsün....
        if ($ayaradi == '' || empty($ayaradi) || $ayaradi == NULL)
        {
            return '';
        }

        if (count($this->ayar_dizi) > 0)
        {
            return $this->ayar_dizi[$ayaradi];
        }
        else
        {
            //ayarları getirelim...
            $this->get_ayarlar();

            return $this->ayar_dizi[$ayaradi];
        }

    }

    /**
     * Ayarlar tablosuna ayar ekler
     *
     * @param string $ayaradi
     * @param string $deger
     * @return boolean
     */
    function ayar_ekle($ayaradi, $deger)
    {
        //ayar adı boşsa, boş değer dönsün....
        if (empty($ayaradi) || empty($deger) )
        {
            return FALSE;
        }

        $ayarekle = $this->ci->db->insert($this->table, array('ayar' => $ayaradi, 'deger' => $deger));

        if ($this->ci->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }

    /**
     * İlgili Ayarı Günceller...
     *
     * @param string $ayaradi
     * @param string $deger
     * @return boolean
     */

    function ayar_guncelle($ayaradi, $deger)
    {
        //ayar adı boşsa, boş değer dönsün....
        if (empty($ayaradi) )
        {
            return FALSE;
        }

        $ayarguncelle = $this->ci->db->update($this->table, array('deger' => $deger), array('ayar' => $ayaradi));

        if ($this->ci->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    /**
     * İlgili Ayarı, Ayarlar Tablosundan Siler
     *
     * @param string $ayaradi
     * @return boolean
     */

    function ayar_sil($ayaradi)
    {
        //ayar adı boşsa, boş değer dönsün....
        if (empty($ayaradi) || $ayaradi == '')
        {
            return FALSE;
        }

        $ayarsil = $this->ci->db->delete($this->table, array('ayar' => $ayaradi));

        if ($this->ci->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }

    /**
     * Ayarlar tablosunda ilgili ayarın olup olmadığını kontrol eder...
     *
     * @param string $ayaradi
     * @return boolean
     */

    function ayar_varmi($ayaradi)
    {
        //ayar adı boşsa, boş değer dönsün....
        if (empty($ayaradi) || $ayaradi == '' )
        {
            return FALSE;
        }

        if ( array_key_exists($ayaradi, $this->ayar_dizi))
        {
            return TRUE;
        }
        else
        {
            //ayar var mı bakalım..
            $ayar = $this->ci->db->get_where($this->table, array('ayar' => $ayaradi));

            if ($ayar->num_rows() > 0)
            {
                $this->get_ayarlar();
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

    }


}