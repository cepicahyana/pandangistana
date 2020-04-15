<?php $con=new konfig(); $dp=$con->dataProfile($this->session->userdata("id")); ?> 
<?php
$Chat="";
$dc=$dataChat;

$this->load->model("m_profile","profile");
if($dc->id_admin==$this->session->userdata("id")){ ?>
<?php 
$dp=$this->profile->dataProfile($dc->id_admin);
$Chat='
<div class="conversation-item item-right clearfix">
<div class="conversation-user">
<img width="55px" height="50px" src="'.base_url().'file_upload/dp/'.$dp->poto.'" alt=""/>
</div>
<div class="conversation-body">
<div class="name">
'.$dp->owner.'
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

 }else{ 
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
?>
