<?php  
$uri =  $_SERVER['REQUEST_URI'];

?>
<div class="atbox_module">
                    	<div class="infotitle">TÀI KHOẢN - ĐƠN HÀNG</div>
                        <ul>
                            <li class="<?php  echo (trim($uri,'/')=='account/settings.php')?'curent':''; ?>"><i class="cycle"></i><a href="/account/settings.php">Thông tin</a></li>
                            <li class="<?php  echo (trim($uri,'/')=='order/index.php')?'curent':''; ?>"><i class="cycle"></i><a href="/order/index.php">Đơn hàng</a></li>
                            <li class="<?php  echo (trim($uri,'/')=='account/refer.php')?'curent':''; ?>"><i class="cycle"></i><a href="/account/refer.php">Mời bạn bè</a></li>
                            <li class="<?php  echo (trim($uri,'/')=='account/logout.php')?'curent':''; ?>"><i class="cycle"></i><a href="/account/logout.php">Đăng xuất</a></li>
	                    </ul>
                    </div>