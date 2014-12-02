<div id="order-pay-dialog" class="order-pay-dialog-c" style="width:380px;">
  <h3><span id="order-pay-dialog-close" class="close" onclick="return X.boxClose();">close</span><?php echo $category?'Edit':'New'; ?> <?php echo $zone[1]; ?></h3>
  <div style="overflow-x:hidden;padding:10px;">
    <p>English name, English name Repeat: require unique classification</p>
    <form method="post" action="/backend/category/edit.php" class="validator">
      <input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
      <input type="hidden" name="zone" value="<?php echo $zone[0]; ?>" />
      <table width="96%" class="coupons-table">
        <tr>
          <td width="80" nowrap><b>Parent category：</b></td>
          <td>
          	<select name="parent" id="parent">
                <option value="0">---Select---</option>
                <?php
                $categories = DB::LimitQuery('category', array(		
					'condition' => "zone = 'group'",
					'order' => 'ORDER BY sort_order, name',
				));
				$categories = processCategoryOption($categories);
				$selectedItem = $category['parent'];
				foreach($categories as $index=>$item)
				{
					$key = $item['id'];
					$value = $item['name'];
					
                  $checked = (string)$selectedItem == (string)$key ||  (string)$selectedItem == (string)$value ? " selected=\"selected\"" : "";
                  echo "<option title='". $value ."' value=\"" . $key . "\"" . $checked . ">" . $value . "</option>";
                }									
                ?>
            </select>
          </td>
        </tr>
        <tr>
          <td width="80" nowrap><b>Select Icon:</b></td>
          <td>
          	<?
            $icons = array(	
					'/static/img/icon-dulich.png',
					'/static/img/icon-giaitri.png',
					'/static/img/icon-thoitrang.png',
					'/static/img/icon-phukien.png',
					'/static/img/icon-mebe.png',					
					'/static/img/icon-suckhoe.png',
					'/static/img/icon-giadung.png',
					'/static/img/icon-congnghe.png',
					'/static/img/icon-nhahang.png',
					
					'/static/img/icon-thoitrang3.png',
					'/static/img/icon-giadung1.png',
					'/static/img/icon-dulich1.png',
					'/static/img/icon-thoitrangnu.png',
					'/static/img/icon-nhahang1.png',
					'/static/img/icon-congnghe1.png',
					'/static/img/icon-suckhoe1.png',
					'/static/img/icon-phukien1.png',
					'/static/img/icon-dulich2.png',
					'/static/img/icon-mebe1.png',
					'/static/img/icon-giaitri3.png',
					'/static/img/icon-giaitri_1.png',
					
					);
			$i = 0;
			foreach($icons as $item)
			{
				$checked = $category['icon_category'] == $item ? 'checked="checked"' : '';
				echo '<input type="radio" ' . $checked . ' name="icon_category" value="'.$item.'"/> <img src="' . $item . '" />';	
				if($i > 0 && $i % 4 == 0)
					echo "<br>";
				$i++;
			}
			?>
          </td>
        </tr>
        <tr>
          <td width="80" nowrap><b>English:</b></td>
          <td><input type="text" name="name" value="<?php echo $category['name']; ?>" require="true" datatype="require" class="f-input" /></td>
        </tr>
        <tr>
          <td nowrap><b>English name Repeat:</b></td>
          <td><input type="text" name="ename" value="<?php echo $category['ename']; ?>" require="true" datatype="english" class="f-input" style="text-transform:lowercase;" /></td>
        </tr>
        <tr>
          <td nowrap><b>First letter：</b></td>
          <td><input type="text" name="letter" value="<?php echo $category['letter']; ?>" maxLength="1" require="true" datatype="english" class="f-input" style="text-transform:uppercase;" /></td>
        </tr>
        <tr>
          <td nowrap><b>Category：</b></td>
          <td><input type="text" name="czone" value="<?php echo $category['czone']; ?>" class="f-input" /></td>
        </tr>
        <tr>
          <td nowrap><b>Display(Y/N)：</b></td>
          <td>
          	
            <?
            $arr_display = array('Y'=>'Yes', 'N'=>'No');
			foreach ($arr_display as $key => $value)
			{
				$checked = $category['display'] == $key ? 'checked="checked"' : '';
				echo '<input type="radio" ' . $checked . ' name="display" value="'.$key.'"/>' . $value . "<br>";	
			}
			?>
          </td>
        </tr>
        <tr>
          <td nowrap><b>Sort (descending)：</b></td>
          <td><input type="text" name="sort_order" value="<?php echo intval($category['sort_order']); ?>" class="f-input" onkeyup="this.value=this.value.replace(/[^\d]/,'')" /></td>
        </tr>
        <tr>
          <td colspan="2" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Save" class="formbutton" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
