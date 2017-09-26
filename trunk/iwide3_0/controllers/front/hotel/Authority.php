<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Authority extends MY_Controller {
    function __construct() {
        parent::__construct ();
    }
    function alist() {
        echo '<html><title>模块</title><script type="text/javascript" src="http://ihotels.iwide.cn/public/media/scripts/jquery.js"></script>';
        echo '<p><img src="http://7n.cdn.iwide.cn/public/uploads/201709/qf222117256232.png" /></p>';
        $sql='SELECT * FROM `iwide_tmp_authority_modules` ';
        $modules=$this->db->query($sql)->result_array();
        $sql="SELECT * FROM `iwide_tmp_authority_modules` m join iwide_tmp_authority_controllers c on m.module_code=c.module where (c.ctlr_code=c.ctlr_name or c.ctlr_name='') and c.ctlr_state!=2 group by m.module_code";
        $ctlr_check=$this->db->query($sql)->result_array();
        $ctlr_check=array_column($ctlr_check, NULL,'module_code');
        $sql="SELECT m.module_code FROM `iwide_tmp_authority_modules` m join iwide_tmp_authority_controllers c join iwide_tmp_authority_functions f on m.module_code=c.module and f.ctlr_id=c.ctlr_id where (f.func_code=f.func_name or f.func_name='') and f.func_state!=2 group by m.module_code";
        $func_check=$this->db->query($sql)->result_array();
        $func_check=array_column($func_check, NULL,'module_code');
        foreach ( $modules as $m ) {
            echo '<a href="'.site_url ( 'hotel/authority/ctlr' ).'?module='.$m ['module_code'].'" >' .  $m ['module_name'] . '</a>';
            if (isset($ctlr_check[$m['module_code']])){
                echo '  <span style="color:red">有功能名称未完善</span> ';
            }
            if (isset($func_check[$m['module_code']])){
                echo '  <span style="color:orange">有方法名称未完善</span>';
            }
            echo '  <span style="color:red" id="' . $m ['module_code'] . '"></span><br /><br />';
        }
        echo '</html>';
    }
    function ctlr() {
        $module =  $this->input->get ( 'module' ) ;
        if (empty ( $module )) {
            echo '无';
            exit ();
        }
        $this->db->where('module_code',$module);
        $module=$this->db->get('tmp_authority_modules')->row_array();
        if (empty ( $module )) {
            echo '无';
            exit ();
        }
        $sql="SELECT * FROM `iwide_tmp_authority_controllers` WHERE `module` LIKE '".$module['module_code']."'";
        $ctlrs=$this->db->query($sql)->result_array();
        $sql="SELECT c.ctlr_id FROM 
                iwide_tmp_authority_controllers c join iwide_tmp_authority_functions f on c.ctlr_id=f.ctlr_id
                 where (f.func_code=f.func_name or func_name='') and func_state!=2 group by ctlr_id";
        $func_check=$this->db->query($sql)->result_array();
        $func_check=array_column($func_check, NULL,'ctlr_id');
        echo '<html><title>'.$module['module_name'].'</title><script type="text/javascript" src="http://ihotels.iwide.cn/public/media/scripts/jquery.js"></script>';
        echo "<h1>".$module['module_name']."</h1>";
        echo "<h4>功能列表:（有'！'表示有信息未完善）(代码与名称相同的视为未完善，若该权限已弃用，请改为无效状态)</h4>";
        foreach ($ctlrs as $c){
            echo '<a href="#'.$c['ctlr_id'].'_div">'.$c['ctlr_name'];
            if (isset($func_check[$c['ctlr_id']]) || ($c['ctlr_state'] !=2 && (empty($c['ctlr_name']) || $c['ctlr_name']==$c['ctlr_code']))){
                echo '<span style="color:red">！</span>';
            }
            echo '</a>&nbsp;&nbsp;';
        }
        $url=site_url('hotel/authority/func');
        foreach ($ctlrs as $c){
            echo '<div name="'.$c['ctlr_id'].'_div" id="'.$c['ctlr_id'].'_div">';
            echo '<h5>'.$c['ctlr_name'].':</h5>';
            echo '<p>代码：'.$c['ctlr_code'].'&nbsp;&nbsp;<a href="'.$url.'?ctlr='.$c['ctlr_id'].'">方法列表';
            if (isset($func_check[$c['ctlr_id']])){
                echo '<span style="color:red">！</span>';
            }
            echo '</a></p>';
            echo '<p>名称：<input id="'.$c['ctlr_id'].'ctlr_name" value="'.$c['ctlr_name'].'" />';
            echo '<p>描述：<textarea id="'.$c['ctlr_id'].'ctlr_des">'.$c['ctlr_des'].'</textarea>';
            echo '<p>状态：';
            echo '<input type="hidden" id="'.$c['ctlr_id'].'status" value="'.$c['ctlr_state'].'"/>';
            echo '<input onclick="$('."'#".$c['ctlr_id']."status').val(1)".'" style="width:1em;height:1em" type="radio" name="'.$c['ctlr_id'].'_ctlr_status" value="1"';
            if ($c['ctlr_state']==1){
                echo 'checked';
            }
            echo '/>有效';
            echo '<input onclick="$('."'#".$c['ctlr_id']."status').val(2)".'" style="width:1em;height:1em" type="radio" name="'.$c['ctlr_id'].'_ctlr_status" value="0"';
            if ($c['ctlr_state']==2){
                echo 'checked';
            }
            echo '/>无效';
            echo '</p>';
            echo '<button onclick="save('.$c['ctlr_id'].')" >保存</button> <span id="'.$c['ctlr_id'].'_tips" style="color:red"></span>';
            echo '</div>';
        }
        $url=site_url('hotel/authority/save_ctlr');
        echo <<<END
<script >
    function save(ctlr_id){
        var name_key=ctlr_id+'ctlr_name';
        var ctlr_name=$('#'+name_key).val();
        var des_key=ctlr_id+'ctlr_des';
        var ctlr_des=$('#'+des_key).val();
        var status_key=ctlr_id+'status';
        var status=$('#'+status_key).val();
        if(!ctlr_name){
            alert('不能为空你知道吗');
            return;
        }
        $.get("$url",{
                ctlr_id:ctlr_id,
                name:ctlr_name,
                des:ctlr_des,
                status:status
            },function(data){
            if(data==1){
                $('#'+ctlr_id+'_tips').html('修改成功');
            }else{
                $('#'+ctlr_id+'_tips').html('修改失败或内容未更改，请重试');
            }
        });
    }
</script>
END;
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '</html>';
    }
    function save_ctlr(){
        $name=$this->input->get('name',true);
        $des=$this->input->get('des',true);
        $ctlr_id=intval($this->input->get('ctlr_id',true));
        $status=intval($this->input->get('status',true));
        $status == 2 or $status=1;
        $this->db->where('ctlr_id',$ctlr_id);
        $this->db->update('tmp_authority_controllers',array('ctlr_name'=>$name,'ctlr_des'=>$des,'ctlr_state'=>$status));
        if ($this->db->affected_rows()>0){
            echo 1;
        }else{
            echo 0;
        }
    }
    function func() {
        $cotroller =  intval($this->input->get ( 'ctlr' ) );
        if (empty ( $cotroller )) {
            echo '无';
            exit ();
        }
        $this->db->where('ctlr_id',$cotroller);
        $cotroller=$this->db->get('tmp_authority_controllers')->row_array();
        if (empty ( $cotroller )) {
            echo '无';
            exit ();
        }
        $sql="SELECT * FROM `iwide_tmp_authority_functions` WHERE `ctlr_id` = ".$cotroller['ctlr_id'];
        $functions=$this->db->query($sql)->result_array();
        echo '<html><title>'.$cotroller['ctlr_name'].'</title><script type="text/javascript" src="http://ihotels.iwide.cn/public/media/scripts/jquery.js"></script>';
        echo "<h1>".$cotroller['ctlr_name']."(".$cotroller['ctlr_code'].")</h1>";
        echo "<h4>方法列表:（有'！'表示未完善）(代码与名称相同的视为未完善，若该权限已弃用，请改为无效状态)</h4>";
        foreach ($functions as $f){
            echo '<a href="#'.$f['func_id'].'_div">'.$f['func_name'].'('.$f['func_code'].')';
            if ($f['func_state'] !=2 && (empty($f['func_name']) || $f['func_name']==$f['func_code'])){
                echo '<span style="color:red">！</span>';
            }
            echo '</a>&nbsp;&nbsp;';
        }
        foreach ($functions as $f){
            echo '<div name="'.$f['func_id'].'_div" id="'.$f['func_id'].'_div">';
            echo '<h5>'.$f['func_name'].':</h5>';
            echo '<p>代码：'.$f['func_code'].'</p>';
            echo '<p>名称：<input id="'.$f['func_id'].'func_name" value="'.$f['func_name'].'" />';
            echo '<p>描述：<textarea id="'.$f['func_id'].'func_des">'.$f['func_des'].'</textarea>';
            echo '<p>状态：';
            echo '<input type="hidden" id="'.$f['func_id'].'status" value="'.$f['func_state'].'"/>';
            echo '<input onclick="$('."'#".$f['func_id']."status').val(1)".'" style="width:1em;height:1em" type="radio" name="'.$f['func_id'].'_ctlr_status" value="1"';
            if ($f['func_state']==1){
                echo 'checked';
            }
            echo '/>有效';
            echo '<input onclick="$('."'#".$f['func_id']."status').val(2)".'" style="width:1em;height:1em" type="radio" name="'.$f['func_id'].'_ctlr_status" value="0"';
            if ($f['func_state']==2){
                echo 'checked';
            }
            echo '/>无效';
            echo '</p>';
            echo '<button onclick="save('.$f['func_id'].')" >保存</button> <span id="'.$f['func_id'].'_tips" style="color:red"></span>';
            echo '</div>';
        }
        $url=site_url('hotel/authority/save_func');
        echo <<<END
<script >
    function save(func_id){
        var name_key=func_id+'func_name';
        var func_name=$('#'+name_key).val();
        var des_key=func_id+'func_des';
        var func_des=$('#'+des_key).val();
        var status_key=func_id+'status';
        var status=$('#'+status_key).val();
        if(!func_name){
            alert('不能为空你知道吗');
            return;
        }
        $.get("$url",{
                func_id:func_id,
                name:func_name,
                des:func_des,
                status:status
            },function(data){
            if(data==1){
                $('#'+func_id+'_tips').html('修改成功');
            }else{
                $('#'+func_id+'_tips').html('修改失败或内容未更改，请重试');
            }
        });
    }
</script>
END;
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        echo '</html>';
    }
    function save_func(){
        $name=$this->input->get('name',true);
        $des=$this->input->get('des',true);
        $func_id=intval($this->input->get('func_id',true));
        $status=intval($this->input->get('status',true));
        $status == 2 or $status=1;
        $this->db->where('func_id',$func_id);
        $this->db->update('tmp_authority_functions',array('func_name'=>$name,'func_des'=>$des,'func_state'=>$status));
        if ($this->db->affected_rows()>0){
            echo 1;
        }else{
            echo 0;
        }
    }
}