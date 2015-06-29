<?php

class Widgets {

	public $ci;
	public $widgets = NULL;
	public $tema;
	public $table = "widgets";
    public $modul = null;
	
	function __construct($config = array())
	{	
		$this->ci =& get_instance();
		
		$this->tema = $this->ci->config->item('site_tema');
		
		//config değişkenleri yükleniyor...
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		
		//tüm widgetler sorgulanıyor...
		if ($this->widgets == NULL)
		{
            $this->ci->db->order_by('sira', 'ASC');
			$wid = $this->ci->db->get($this->table);
			
			if ($wid->num_rows() > 0)
			{
				$this->widgets = $wid->result();
			}
			else
			{
				$this->widgets = NULL;
			}
		}
	}
	
	//yukleme fonksiyonu..
	public function initialize($config = array())
	{
		if (count($config) > 0)
		{
			foreach ($config as $key => $value)
			{
				$this->$key = $value;
			}
		}
		
	}

    /**
     * @return null
     */
    public function getModul()
    {
        return $this->modul;
    }

    /**
     * @param null $modul
     */
    public function setModul($modul)
    {
        $this->modul = $modul;
        return $this;
    }

    public function widget_dir($modul)
    {
        $this->setModul($modul);
        return $this;
    }
	//dosya okuma
	public function widget_oku($file, $data = NULL)
	{
        //gelenleri yolluyoruz...
        $_data['_veri'] = $data;

        if ( null != $this->getModul() )
        {
            $file = 'site/'.$this->tema .'/views/modules/'. $this->getModul() .'/widgets/'.$file;
        }
        else
        {
            $file = 'site/'.$this->tema .'/views/widgets/'.$file;
        }


        //dosya varsa
        if (!file_exists($file)) {

            $output = $this->ci->load->view($file, $_data, TRUE);

            return $output;

        } else {
            return 'Widget Yüklenemedi..!';
        }
	}
	
	
	//widget konumları
	public function widget($pozisyon = '')
	{
        if ($pozisyon == '')
        {
            die('Widget Pozisyonu Belirtilmemiş');
        }

        if ($this->widgets != NULL)
        {
            $output = '';

            foreach($this->widgets as $widget)
            {
                if ($widget->pozisyon == $pozisyon)
                {
                    if ($widget->kategori != NULL)
                    {
                        $output .= $this->widget_oku($widget->dosya, $widget->kategori);
                    }
                    else
                    {
                        $output .= $this->widget_oku($widget->dosya);
                    }
                }
            }
        }
        else
        {
            $output = '';
        }

        return $output;
		
	}
	
	
	public function hook($fonksiyon = '', $params=array())
	{
		//değişkenler boş ise birşey döndürmesin...
		if ($fonksiyon == '' || count($params))
		{
			return;
		}

        //fonksiyonu çalıştırıyoruz
        if (count($params) > 0)
        {
            return call_user_func_array($fonksiyon, $params);
        }
        else
        {
            return call_user_func($fonksiyon, $params);
        }
    }
		
}