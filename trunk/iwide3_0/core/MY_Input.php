<?php
use App\libraries\Support\Collection;

/**
 * User: renshuai <renshuai@mofly.cn>
 * Date: 2017/5/5
 * Time: 11:25
 */
class MY_Input extends CI_Input
{
    /**
     * @param null $index
     * @param null $xss_clean
     * @param null $default
     * @return mixed|null
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function get($index = NULL, $xss_clean = NULL, $default = null)
    {
        $value = parent::get($index, $xss_clean);
        if ( empty($value) && !empty($default) ) {
            $value = $default;
        }

        //比如soma 的渠道channel参数，需要在分享和下单等时候携带
        //设置方式$this->session->set_tempdata('channel', 2, 3000);
        //$this->input->get()也可以拿到了session tempdata的值
        if (is_null($index) && is_array($value)) {
            $ci = &get_instance();
            $temp = $ci->session->tempdata();
            
            $value = array_merge($value, $temp);
        }

        return $value;
    }

    /**
     * @param string $index
     * @param null $xss_clean
     * @param null $default
     * @return mixed|null
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function get_post($index, $xss_clean = null, $default = null)
    {
        $value = parent::get_post($index, $xss_clean);
        if ( empty($value) && !empty($default) ) {
            $value = $default;
        }
        return $value;
    }

    /**
     * @param string $index
     * @param null $xss_clean
     * @param null $default
     * @return mixed|null
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function post_get($index, $xss_clean = null, $default = null)
    {
        $value = parent::get_post($index, $xss_clean);
        if ( empty($value) && !empty($default) ) {
            $value = $default;
        }
        return $value;
    }

    /**
     * 获得请求header是application/json，的json字符串
     * 并且转化为Collection对象
     *
     * @return Collection|null
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function input_json()
    {
        $raw_input_stream = file_get_contents('php://input');
        $arr = json_decode($raw_input_stream, true);
        if (json_last_error()) {
            return null;
        }

        return new Collection($arr);
    }

}