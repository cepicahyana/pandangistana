<?php $con=new konfig(); $dp=$con->dataProfile($id);  ?> 
<?php
$Chat="";
$this->db->where("focus",$id);
$this->db->where("status","0");
$this->db->where("id_admin!=",$this->session->userdata("id"));
$dataChat=$this->db->get("data_chat")->result();
$dc=$dataChat;

$this->load->model("m_profile","profile");
foreach($dc as $dc)
{
$Chat='
<div class="conversation-item item-left clearfix">
<div class="conversation-user">
<img width="55px" height="50px" src="'.base_url().'file_upload/dp/'.$dp->poto.'" alt=""/>
</div>
<div class="conversation-body">
<div class="name">
Admin
</div>
<div>
<span class="time hidden-xs">
'.$dc->date.'
</span>
</div>
<div class="text">
'.$dc->chat.'
</div>
</div>
</div>';
}

$Chat.="<p class='isicat nextChat'></p>";
echo $Chat;

$this->data_user->updateStatusChat($id);
?>
