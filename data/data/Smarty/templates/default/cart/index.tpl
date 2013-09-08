<!--{*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->

<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/facebox.js"></script>
<link rel="stylesheet" type="text/css" href="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/facebox.css" media="screen" />
<script type="text/javascript">//<![CDATA[
    $(document).ready(function() {
        $('a.expansion').facebox({
            loadingImage : '<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/loading.gif',
            closeImage   : '<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/closelabel.png'
        });
    });
//]]></script>

<div id="under02column">
    <div id="under02column_cart">
        <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/cart/title.jpg" width="700" height="40" alt="現在のカゴの中" /></h2>

    <div class="totalmoneyarea">
    <!--{if $smarty.const.USE_POINT !== false || count($arrProductsClass) > 0}-->
        <!--★ポイント案内★-->
        <!--{if $smarty.const.USE_POINT !== false}-->
            <div class="point_announce">
                <!--{if $tpl_login}-->
                    <span class="user_name"><!--{$tpl_name|h}--> 様</span>の、現在の所持ポイントは「<span class="point"><!--{$tpl_user_point|number_format|default:0}--> pt</span>」です。<br />
                <!--{else}-->
                    ポイント制度をご利用になられる場合は、会員登録後ログインしていただきますようお願い致します。<br />
                <!--{/if}-->
            </div>
        <!--{/if}-->
    <!--{/if}-->

    <p class="totalmoney_area">
        <!--{* カゴの中に商品がある場合にのみ表示 *}-->
        <!--{if count($cartKeys) > 1}-->
            <span class="attentionSt"><!--{foreach from=$cartKeys item=key name=cartKey}--><!--{$arrProductType[$key]}--><!--{if !$smarty.foreach.cartKey.last}-->、<!--{/if}--><!--{/foreach}-->は同時購入できません。<br />
                        お手数ですが、個別に購入手続きをお願い致します。
            </span>
        <!--{/if}-->

        <!--{if strlen($tpl_error) != 0}-->
            <p class="attention"><!--{$tpl_error|h}--></p>
        <!--{/if}-->

        <!--{if strlen($tpl_message) != 0}-->
            <p class="attention"><!--{$tpl_message|h|nl2br}--></p>
        <!--{/if}-->
    </p>
    <!--{if count($cartItems) > 0}-->
    <!--{foreach from=$cartKeys item=key}-->
            <!--{if count($cartKeys) > 1}-->
            <h3><!--{$arrProductType[$key]}--></h3>
                <p>
                    <!--{$arrProductType[$key]}-->の合計金額は「<span class="price"><!--{$tpl_total_inctax[$key]|number_format}-->円</span>」です。
                    <!--{if $key != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
                        <!--{if $arrInfo.free_rule > 0}-->
                            <!--{if !$arrData[$key].is_deliv_free}-->
                                あと「<span class="price"><!--{$tpl_deliv_free[$key]|number_format}-->円</span>」で送料無料です！！
                            <!--{else}-->

                                現在、「<span class="attention">送料無料</span>」です！！
                            <!--{/if}-->
                        <!--{/if}-->
                    <!--{/if}-->
                </p>
            <!--{else}-->
                <p>
                    お買い上げ商品の合計金額は「<span class="price"><!--{$tpl_total_inctax[$key]|number_format}-->円</span>」です。
                    <!--{if $key != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
                        <!--{if $arrInfo.free_rule > 0}-->
                            <!--{if !$arrData[$key].is_deliv_free}-->
                                あと「<span class="price"><!--{$tpl_deliv_free[$key]|number_format}-->円</span>」で送料無料です！！
                            <!--{else}-->
                                現在、「<span class="attention">送料無料</span>」です！！
                            <!--{/if}-->
                        <!--{/if}-->
                    <!--{/if}-->
                </p>
            <!--{/if}-->
    <!--{/foreach}-->
    <!--{/if}-->
    </div>

    <!--{if count($cartItems) > 0}-->
    <!--{foreach from=$cartKeys item=key}-->
    <div class="form_area">
        <form name="form<!--{$key}-->" id="form<!--{$key}-->" method="post" action="?">
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <input type="hidden" name="mode" value="confirm" />
            <input type="hidden" name="cart_no" value="" />
            <input type="hidden" name="cartKey" value="<!--{$key}-->" />
            <input type="hidden" name="category_id" value="<!--{$tpl_category_id|h}-->" />

            <table summary="商品情報">
                <!--{*
                <col width="40px" />
                <col width="92px" />
                <col width="337px" />
                <col width="64px" />
                <col width="87px" />
                <col width="69px" />
                *}-->
                <tr>
                    <th class="alignC">削除</th>
                    <th class="alignC">商品写真</th>
                    <th class="alignC">商品名</th>
                    <th class="alignC">単価</th>
                    <th class="alignC">個数</th>
                    <th class="alignC">小計</th>
                </tr>
                <!--{foreach from=$cartItems[$key] item=item}-->
                    <tr style="<!--{if $item.error}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->">
                        <td><a href="?" onclick="fnFormModeSubmit('form<!--{$key}-->', 'delete', 'cart_no', '<!--{$item.cart_no}-->'); return false;">削除</a></td>
                        <td class="alignC">
                        <a class="expansion" target="_blank"
                                <!--{if $item.productsClass.main_image|strlen >= 1}--> href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$item.productsClass.main_image|sfNoImageMainList|h}-->"
                                <!--{/if}-->
                                >
                                <img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$item.productsClass.main_list_image|sfNoImageMainList|h}-->&amp;width=65&amp;height=65" alt="<!--{$item.productsClass.name|h}-->" />
                            </a>
                        </td>
                        <td><!--{* 商品名 *}--><strong><!--{$item.productsClass.name|h}--></strong><br />
                            <!--{if $item.is_JBStainplate == true}-->
                                <!--{if $item.productsClass.classcategory_name2 != ""}-->
                                    縦：<!--{$item.productsClass.classcategory_name2}--><br />
                                <!--{/if}-->
                                <!--{if $item.width_size != ""}-->
                                    横：<!--{$item.width_size}-->cm
                                <!--{/if}-->
                            <!--{else}-->
                                <!--{if $item.productsClass.classcategory_name1 != ""}-->
                                    <!--{if $item.productsClass.class_name1|@strpos:"車種名" !== FALSE}-->
                                    <!--{assign var=class_name1 value="車種"}-->
                                    <!--{else}-->
                                    <!--{assign var=class_name1 value=$item.productsClass.class_name1}-->
                                    <!--{/if}-->
                                    <!--{$class_name1}-->：<!--{$item.productsClass.classcategory_name1}-->
                                    <!--{if $item.color1 != ""}-->
                                        ：<!--{$item.color1}-->
                                    <!--{/if}-->
                                    <br />
                                <!--{/if}-->
                                <!--{if $item.productsClass.classcategory_name2 != ""}-->
                                    <!--{if $item.productsClass.class_name2|@strpos:"車種名" !== FALSE}-->
                                    <!--{assign var=class_name2 value="車種"}-->
                                    <!--{else}-->
                                    <!--{assign var=class_name2 value=$item.productsClass.class_name2}-->
                                    <!--{/if}-->
                                    <!--{$class_name2}-->：<!--{$item.productsClass.classcategory_name2}-->
                                    <!--{if $item.color2 != ""}-->
                                        ：<!--{$item.color2}-->
                                    <!--{/if}-->
                                <!--{/if}-->
                                <!--{if $item.frill_name != ""}-->
                                    <!--{$item.frill_name}-->
                                <!--{/if}-->
                            <!--{/if}-->
                            <!--{if $item.body_color_classcategory_id != ""}-->
                                表の色：<!--{$item.body_color_classcategory_name}--><br />
                            <!--{/if}-->
                            <!--{if $item.back_color_classcategory_id != ""}-->
                                裏の色：<!--{$item.back_color_classcategory_name}--><br />
                            <!--{/if}-->
                            <!--{if $item.edge_color_classcategory_id != ""}-->
                                フチの色：<!--{$item.edge_color_classcategory_name}--><br />
                            <!--{/if}-->
                            <!--{if $item.edge_size_classcategory_id != ""}-->
                                フチサイズ：<!--{$item.edge_size_classcategory_name}--><br />
                            <!--{/if}-->
                            <!--{if $item.height_size != ""}-->
                                横：<!--{$item.width_size}-->cm × 縦：<!--{$item.height_size}-->cm
                            <!--{/if}-->
                        </td>
                        <td class="alignR">
                            <!--{if $item.body_color_classcategory_id != ""}-->
                                <!--{$item.price|sfCalcIncTax|number_format}-->円
                            <!--{else}-->
                                <!--{if $item.productsClass.price02 != ""}-->
                                    <!--{$item.productsClass.price02|sfCalcIncTax|number_format}-->円
                                <!--{else}-->
                                    <!--{$item.productsClass.price01|sfCalcIncTax|number_format}-->円
                                <!--{/if}-->
                            <!--{/if}-->
                        </td>
                        <td class="alignC" id="quantity">
                        <!--{if $item.sell_piece_size != ""}-->
                            <!--{$item.sell_piece_size}-->m
                        <!--{else}-->
                            <!--{$item.quantity}-->
                            <ul id="quantity_level">
                                <li><a href="?" onclick="fnFormModeSubmit('form<!--{$key}-->','up','cart_no','<!--{$item.cart_no}-->'); return false"><img src="<!--{$TPL_URLPATH}-->img/cart/plus.gif" width="16" height="16" alt="＋" /></a></li>
                                <li><a href="?" onclick="fnFormModeSubmit('form<!--{$key}-->','down','cart_no','<!--{$item.cart_no}-->'); return false"><img src="<!--{$TPL_URLPATH}-->img/cart/minus.gif" width="16" height="16" alt="-" /></a></li>
                            </ul>
                        <!--{/if}-->
                        </td>
                        <td class="alignR"><!--{$item.total_inctax|number_format}-->円</td>
                    </tr>
                <!--{/foreach}-->
                <tr>
                    <th colspan="5" class="alignR">小計</th>
                    <td class="alignR"><!--{$tpl_total_inctax[$key]|number_format}-->円</td>
                </tr>
                <tr>
                    <th colspan="5" class="alignR">合計</th>
                    <td class="alignR"><span class="price"><!--{$arrData[$key].total-$arrData[$key].deliv_fee|number_format}-->円</span></td>
                </tr>
                <!--{if $smarty.const.USE_POINT !== false}-->
                    <!--{if $arrData[$key].birth_point > 0}-->
                        <tr>
                            <th colspan="5" class="alignR">お誕生月ポイント</th>
                            <td class="alignR"><!--{$arrData[$key].birth_point|number_format}-->pt</td>
                        </tr>
                    <!--{/if}-->
                    <tr>
                        <th colspan="5" class="alignR">今回加算ポイント</th>
                        <td class="alignR"><!--{$arrData[$key].add_point|number_format}-->pt</td>
                    </tr>
                <!--{/if}-->
            </table>
            <p class="mini">※商品写真は参考用写真です。ご注文のカラーと異なる写真が表示されている場合でも、商品番号に記載されているカラー表示で間違いございませんのでご安心ください。</p>
            <div class="btn_area">
                <!--{if strlen($tpl_error) == 0}-->                                                                                                                                     <p><img src="<!--{$TPL_URLPATH}-->img/cart/text.gif" width="390" height="30" alt="上記内容でよろしければ「レジへ行く」ボタンをクリックしてください。" /></p>
                <!--{/if}-->
                <p><!--{strip}-->
                        <!--{if $tpl_prev_url != ""}-->
                            <!--{*<a href="<!--{$tpl_prev_url|h}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/cart/b_pageback_on.gif','back<!--{$key}-->');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/cart/b_pageback.gif','back<!--{$key}-->');">*}-->
                            <a href="javascript:history.back();" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/cart/b_pageback_on.gif','back<!--{$key}-->');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/cart/b_pageback.gif','back<!--{$key}-->');">
                                <img src="<!--{$TPL_URLPATH}-->img/cart/b_pageback.gif" alt="戻る" name="back<!--{$key}-->" /></a>
                        <!--{/if}-->
                        <!--{if $tpl_prev_url != "" && strlen($tpl_error) == 0}-->&nbsp;&nbsp;&nbsp;<!--{/if}-->
                        <!--{if strlen($tpl_error) == 0}-->
                            <input type="hidden" name="cartKey" value="<!--{$key}-->" />
                            <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/cart/b_buystep_on.gif',this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/cart/b_buystep.gif',this)" src="<!--{$TPL_URLPATH}-->img/cart/b_buystep.gif" alt="購入手続きへ" name="confirm" />
                        <!--{/if}-->
                <!--{/strip}--></p>
            </div>
        </form>
        </div>
    <!--{/foreach}-->
    <!--{else}-->
        <p class="empty"><span class="attention">※ 現在カート内に商品はございません。</span></p>
    <!--{/if}-->
    </div>
</div>
