<?php
/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 27.02.2017
 * Time: 12:02
 */
//echo 123;
//var_dump($id_cattmr);
?>
<table class="red" width="80%">

    <input type="hidden" name="Goods[<?=$id?>][log_start]" value="<?=date('Y-m-d H:i:s')?>">

    <tr>
        <th>������������</th>
        <td>
            <?=dll(sprintf($sqlCattmr,""), 'name="Goods['.$id.'][id_cattmr]" style="width:auto;" class="select2" onChange1="location.href=\'?id='.$id.'&id_cattmr=\'+this.value+\'&red\'"', $id_cattmr, "")?>
        </td>
    </tr>
    <tr>
        <th>�����</th>
        <td><?=dll("SELECT id,name FROM {$prx}catsr".($id_cattmr?" WHERE id_cattmr={$id_cattmr}":'')." ORDER BY sort", 'name="Goods['.$id.'][id_catsr]" style="width:auto"', $row['id_catsr'], '')?></td>
    </tr>
    <tr>
        <th>���</th>
        <td><input name="Goods[<?=$id?>][kod]" type="text" value="<?=$row['kod']?>"></td>
    </tr>
    <tr>
        <th>��� 2</th>
        <td><input name="Goods[<?=$id?>][kod2]" type="text" value="<?=$row['kod2']?>"></td>
    </tr>
    <tr>
        <th>��������</th>
        <td><input name="Goods[<?=$id?>][name]" type="text" value="<?=$row['name']?>"></td>
    </tr>
    <tr>
        <th>������</th>
        <td>/tovar/<input name="Goods[<?=$id?>][link]" type="text" value="<?=$row['link']?>" style="width:250px;">.htm</td>
    </tr>
    <tr>
        <th<?=(isset($_SESSION['priv']['type']) && $_SESSION['priv']['type'])=='2'?$style:''?>>�����������</th>
        <td>
            <div class="gimg" data-id="<?= $id?>">
                <div class="glist" style="padding-left:0">
                    <div class="add source">
                        <div class="i1"><input type="file" multiple name="Goods[<?=$id?>][gimg][]"></div>
                    </div>
                    <?
                    $ids = getArr("SELECT id FROM {$prx}goods_img WHERE id_goods='{$row['id']}' ORDER BY sort,id");
                    if($count = sizeof($ids))
                    {
                        ?><table>
                        <tbody><?
                        $i=1;
                        foreach($ids as $id_img)
                        {
                            ?>

                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><a href="/images/original/uploads/goods_img/<?=$id_img?>.jpg" target="my" onClick="openWindow(800,600)" title="�����������"><img src="/images/small/uploads/goods_img/<?=$id_img?>.jpg"></a></td>
                                        <td>
                                            <a href="goods_img.php?action=moveup&id=<?=$id_img?>" target="ajax"><img src="img/im-arup.gif" hspace="2" alt="�����" title="�����" align="absmiddle"></a>
                                            <a href="goods_img.php?action=movedown&id=<?=$id_img?>" target="ajax"><img src="img/im-ardown.gif" hspace="2" alt="����" title="����" align="absmiddle"></a>
                                        </td>
                                        <td>
                                            <a href="goods_img.php?action=del&id=<?=$id_img?>" title="�������" target="ajax"><img src="img/del16.gif"></a>
                                        </td>
                                    </tr>
                            <?
                        }
                        ?></tbody>
                        </table><?
                    }
                    ?>
                </div>
            </div>
            <? /*<a href="goods_img.php?id_goods=<?=$id?>" target="my2" onClick="win=window.open('','my2','resizable=yes,width=512,height=384,scrollbars=1');win.focus();">�������������</a>*/ ?>
        </td>
    </tr>
    <tr>
        <th<?=$style?>>������� ��������</th>
        <td><textarea class="ckeditor-textarea" name="Goods[<?=$id?>][text1]"><?=$row['text1']?></textarea></td>
    </tr>
    <tr>
        <th<?=$style?>>������ ��������</th>
        <td><textarea class="ckeditor-textarea" name="Goods[<?=$id?>][text2]"><?=$row['text2']?></textarea></td>
    </tr>
    <tr>
        <th>����� "��������"</th>
        <td><textarea class="ckeditor-textarea" name="Goods[<?=$id?>][warranty_text]"><?=$row['warranty_text']?></textarea></td>
    </tr>
    <tr>
        <th>����� "��������"</th>
        <td><textarea class="ckeditor-textarea" name="Goods[<?=$id?>][delivery_text]"><?=$row['delivery_text']?></textarea></td>
    </tr>
    <tr>
        <th>����</th>
        <td>
            <input name="Goods[<?=$id?>][price]" value="<?=$row["price"]?>" style="width:100px;">

            <?=dllEnum("SHOW COLUMNS FROM {$prx}goods LIKE 'valuta'", "name='Goods[{$id}][valuta]' style='width:auto;'", $row["valuta"])?>
        </td>
    </tr>
    <tr>
        <th>�������</th>
        <td><input name="Goods[<?=$id?>][new]" type="checkbox" <?=$row['new'] ? "checked" : ""?> style="width:auto;" value="1"></td>
    </tr>
    <tr>
        <th>��������� � YML</th>
        <td><input type="checkbox" value="1" name="Goods[<?=$id?>][yml]" <?=$id ? ($row['yml'] ? "checked" : "") : "checked"?>></td>
    </tr>

    <tr>
        <th>� �������</th>
        <td><input name="Goods[<?=$id?>][nalich]" type="checkbox" <?=$id ? ($row['nalich'] ? "checked" : "") : "checked"?> style="width:auto;" value="1"></td>
    </tr>

    <tr>
        <th>����������</th>
        <td>
            <input type="hidden" name="Goods[<?=$id?>][sale]" value="0">
            <input name="Goods[<?=$id?>][sale]" type="checkbox" <?=$row['sale'] ? "checked" : ""?> style="width:auto;" value="1"></td>
    </tr>

    <tr>
        <th>������</th>
        <td><input name="Goods[<?=$id?>][hide]" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <input type="submit" value="���������" style="width:80px;" onClick1="frm_edit_submit(this.form)">
        </td>
    </tr>
</table>