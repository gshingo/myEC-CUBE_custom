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

<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/products.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/facebox.js"></script>
<link rel="stylesheet" type="text/css" href="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/facebox.css" media="screen" />
<script type="text/javascript">//<![CDATA[
    // 規格2に選択肢を割り当てる。
    function fnSetClassCategories(form, classcat_id2_selected) {
    //    var $form = $(form);
    //    var product_id = $form.find('input[name=product_id]').val();
    //    var $sele1 = $form.find('select[name=classcategory_id1]');
    //    var $sele2 = $form.find('select[name=classcategory_id2]');
    //    setClassCategories($form, product_id, $sele1, $sele2, classcat_id2_selected);
    }
    $(document).ready(function() {
        $('a.expansion').facebox({
            loadingImage : '<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/loading.gif',
            closeImage   : '<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.facebox/closelabel.png'
        });
    });


// サブウィンドウを開く処理
function disp(url){

	window.open(url, "window_name", "width=700,height=600,scrollbars=yes,resizable=yes,status=yes");

}

document.write(unescape("%3Cscript src='" + document.location.protocol + "//d.rcmd.jp/www.route-2.net/item/recommend.js' type='text/javascript' charset='UTF-8'%3E%3C/script%3E"));

//]]></script>

<img width="960" height="3" id="header_line" name="header_line" alt="header_line" src="<!--{$TPL_URLPATH}-->img/header/header_bar.gif">

<!--詳細ここから-->
<div id="detail_column">
    <h2><!--★商品名★--><!--{$arrProduct.name|h}--></h2>
    <div id="detail_area">
        <div id="detail_photoblock">
            <!--★画像★-->
            <div class="photo">
                <!--{assign var=key value="main_image"}-->
                <!--★画像★-->
                <!--{if $arrProduct.main_large_image|strlen >= 1}-->
                    <a
                        href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_large_image|h}-->"
                        class="expansion"
                        target="_blank"
                    >
                <!--{/if}-->
                    <img src="<!--{$arrFile[$key].filepath|h}-->" width="<!--{$arrFile[$key].width}-->" height="<!--{$arrFile[$key].height}-->" alt="<!--{$arrProduct.name|h}-->" class="picture" />
                <!--{if $arrProduct.main_large_image|strlen >= 1}-->
                    </a>
                <!--{/if}-->
            </div>
            <!--{if $arrProduct.main_large_image|strlen >= 1}-->
                <p>
                    <!--★拡大する★-->
                    <img width="15" height="14" id="expansion01" name="expansion01" alt="画像を拡大する" src="<!--{$TPL_URLPATH}-->img/detail/detail_icon1.gif">
                    <a href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_large_image|h}-->"
                       class="expansion"
                       target="_blank"
                    >商品画像を拡大</a>
                </p>
            <!--{/if}-->
            <!--{if $other_img_flg}-->
            <div id="other_photo">
                <div id="other_photo_main">
                <!--{section name=cnt loop=$smarty.const.PRODUCTSUB_MAX}-->
                    <!--{assign var=ikey value="sub_image`$smarty.section.cnt.index+1`"}-->
                    <!--{if $arrProduct[$ikey]|strlen >= 1}-->
                        <!--▼サブ画像-->
                        <!--{assign var=lkey value="sub_large_image`$smarty.section.cnt.index+1`"}-->
                        <span><!--{strip}-->
                            <!--{if $arrProduct[$lkey]|strlen >= 1}-->
                                <a href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct[$lkey]|h}-->" class="expansion" target="_blank"
                                   <!--{*
                                   onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/button/btn_expansion_on.gif', 'expansion_<!--{$lkey|h}-->');"
                                   onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/button/btn_expansion.gif', 'expansion_<!--{$lkey|h}-->');"
                                   *}-->
                                >
                            <!--{/if}-->
                            <!--{*
                            <img src="<!--{$arrFile[$ikey].filepath}-->" alt="<!--{$arrProduct.name|h}-->" width="<!--{$arrFile[$ikey].width}-->" height="<!--{$arrFile[$ikey].height}-->" />
                            *}-->
                            <img src="<!--{$arrFile[$ikey].filepath}-->" alt="<!--{$arrProduct.name|h}-->" width="<!--{$smarty.const.NORMAL_SUBIMAGE_WIDTH}-->" height="<!--{$smarty.const.NORMAL_SUBIMAGE_WIDTH}-->" />
                            <!--{if $arrProduct[$lkey]|strlen >= 1}-->
                                </a>
                            <!--{/if}-->
                        <!--{/strip}--></span>
                        <!--▲サブ画像-->
                    <!--{/if}-->
                <!--{/section}-->
                </div>
            </div><!--{* //other_photo *}-->
            <!--{/if}-->
        </div><!--{* //detailphotoblock *}-->

        <div id="detail_rightblock">
            <!--▼商品ステータス-->
            <!--{assign var=ps value=$productStatus[$tpl_product_id]}-->
            <!--{if count($ps) > 0}-->
                <ul class="status_icon clearfix">
                    <!--{foreach from=$ps item=status}-->
                    <li>
                        <img src="<!--{$TPL_URLPATH}--><!--{$arrSTATUS_IMAGE[$status]}-->" width="65" height="17" alt="<!--{$arrSTATUS[$status]}-->" id="icon<!--{$status}-->" />
                    </li>
                    <!--{/foreach}-->
                </ul>
            <!--{/if}-->
            <!--▲商品ステータス-->
            <div class="main_comment"><!--★詳細メインコメント★--><!--{$arrProduct.main_comment|nl2br_html}--></div>
            <!--★価格★-->
            <form name="form1" id="form1" method="post" action="?">
                <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
                <div id="detail_price"><!--{strip}-->
                    <div id="detail_price_box1">
                        <!--{*
                        <!--★通常価格★-->
                        <!--{if $arrProduct.price01_min_inctax > 0}-->
                            <dl class="normal_price">
                                <dt><!--{$smarty.const.NORMAL_PRICE_TITLE}-->(税込)：</dt>
                                <dd class="price">
                                    <span id="price01_default">
                                        <!--{if $arrProduct.price01_min_inctax == $arrProduct.price01_max_inctax}-->
                                            <!--{$arrProduct.price01_min_inctax|number_format}-->
                                        <!--{else}-->
                                            <!--{$arrProduct.price01_min_inctax|number_format}-->～<!--{$arrProduct.price01_max_inctax|number_format}-->
                                        <!--{/if}-->
                                    </span><span id="price01_dynamic"></span>
                                    円
                                </dd>
                            </dl>
                        <!--{/if}-->
                        *}-->
                        <!--★販売価格★-->
                        <!--{$smarty.const.SALE_PRICE_TITLE}--><span class="mini"></span>：&nbsp;
                        <span class="price">
                            <b>
                                <!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->
                                <!--{else}-->
                                    <!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
                                <!--{/if}-->
                            </b>
                            &nbsp;円(税込)
                        </span>
                    </div>
                    <!--{if $arrProduct.order_made_flg == 1}-->
                        <input type="hidden" name="order_made_flg" value="<!--{$arrProduct.order_made_flg}-->" />
                        <!--{if $arrProduct.body_color_class_id != ""}-->
                        <div id="detail_price_box5">
                            <font color="black" size=2>表の色<br></font>
                            <select name="body_color_classcategory_id" class="box250">
                                <option label="色を選択して下さい" value="">色を選択して下さい</option>
                                <!--{html_options options=$arrBodyCategory selected=$arrForm.body_color_classcategory_id}-->
                            </select>
                            <!--{if $arrErr.body_color_classcategory_id != ""}-->
                                <br /><span class="attention"><!--{$arrErr.body_color_classcategory_id}--></span>
                            <!--{/if}-->
                        </div>
                        <!--{/if}-->
                        <!--{if $arrProduct.back_color_class_id != ""}-->
                        <input type="hidden" name="back_color_flg" value="1" />
                        <div id="detail_price_box4">
                            <font color="black" size=2>裏の色<br></font>
                            <select name="back_color_classcategory_id" class="box250">
                                <option label="色を選択して下さい" value="">色を選択して下さい</option>
                                <!--{html_options options=$arrBackCategory selected=$arrForm.back_color_classcategory_id}-->
                            </select>
                            <!--{if $arrErr.back_color_classcategory_id != ""}-->
                                <br /><span class="attention"><!--{$arrErr.back_color_classcategory_id}--></span>
                            <!--{/if}-->
                        </div>
                        <!--{/if}-->
                        <!--{if $arrProduct.edge_color_class_id != ""}-->
                        <div id="detail_price_box4">
                            <font color="black" size=2>フチの色<br></font>
                            <select name="edge_color_classcategory_id" class="box250">
                                <option label="色を選択して下さい" value="">色を選択して下さい</option>
                                <!--{html_options options=$arrEdgeCategory selected=$arrForm.edge_color_classcategory_id}-->
                            </select>
                            <!--{if $arrErr.edge_color_classcategory_id != ""}-->
                                <br /><span class="attention"><!--{$arrErr.edge_color_classcategory_id}--></span>
                            <!--{/if}-->
                        </div>
                        <!--{/if}-->
                        <!--{if $arrProduct.edge_size_class_id != ""}-->
                        <div id="detail_price_box4">
                            <font color="black" size=2>フチサイズ<br></font>
                            <select name="edge_size_classcategory_id" class="box250">
                                <option label="規格を選択して下さい" value="">規格を選択して下さい</option>
                                <!--{html_options options=$arrSizeCategory selected=$arrForm.edge_size_classcategory_id}-->
                            </select>
                            <!--{if $arrErr.edge_size_classcategory_id != ""}-->
                                <br /><span class="attention"><!--{$arrErr.edge_size_classcategory_id}--></span>
                            <!--{/if}-->
                        </div>
                        <!--{/if}-->
                        <div id="detail_price_box4">
                              <font color="black" size=2>横サイズ<br></font>
                              <input type="text" name="width_size" class="box54" value="<!--{$arrForm.width_size.value|default:0|h}-->" maxlength="<!--{$smarty.const.INT_LEN}-->" style="<!--{$arrErr.width_size|sfGetErrorColor}-->" />
                              &nbsp;cm
                              <!--{if $arrErr.width_size != ""}-->
                                  <br /><span class="attention"><!--{$arrErr.width_size}--></span>
                              <!--{/if}-->
                        </div>
                        <div id="detail_price_box4">
                              <font color="black" size=2>縦サイズ<br></font>
                              <input type="text" name="height_size" class="box54" value="<!--{$arrForm.height_size.value|default:0|h}-->" maxlength="<!--{$smarty.const.INT_LEN}-->" style="<!--{$arrErr.height_size|sfGetErrorColor}-->" />
                              &nbsp;cm
                              <!--{if $arrErr.height_size != ""}-->
                                  <br /><span class="attention"><!--{$arrErr.height_size}--></span>
                              <!--{/if}-->
                        </div>
                    <!--{/if}-->
                    <input type="hidden" id="getId1" name="classcategory_id1" value="" />
                    <input type="hidden" id="getId2" name="classcategory_id2" value="" />
                    <!--{if $tpl_classcat_find1 != ""}-->
                        <!--{if $tpl_class_name1 == "JBステンプレート"}-->
                            <input type="hidden" name="getClassId1" value="<!--{$tpl_class_id1}-->" />
                            <div id="detail_price_box2" style="font-size:14px;">
                                <font color="black" size=2>数値(cm)を入力して下さい<br></font>
                                <input type="text" id="getJBSize" name="JB_Size" value="<!--{$tpl_JB_Size}-->" size="25px" /> cm
                                <!--{if $arrErr.JB_Size != ""}-->
                                    <br /><span class="attention"><!--{$arrErr.JB_Size}--></span>
                                <!--{/if}-->
                            </div>
                        <!--{elseif $tpl_cloth_flg1 == 1}-->
                            <!--{* 金華山 *}-->
                            <div id="detail_price_box2">
                                <font color="black" size=2>生地<br></font>
                                <input type="text" id="getText" name="kinkazan" value="選択して下さい" size="25px" readonly/>
                                <b><a href="../../user_data/kinkazan.php?p_id=<!--{$tpl_product_id}-->&cat_find=1" target="window_name"
                                      onclick="disp('../../user_data/kinkazan.php?p_id=<!--{$tpl_product_id}-->&cat_find=1')">生地を選ぶ</a></b>
                                <!--{if $arrErr.classcategory_id1 != ""}-->
                                    <font size="4"><br /><span class="attention">※ 生地を選択して下さい</span></font>
                                <!--{/if}-->
                            </div>
                        <!--{else}-->
                            <div id="detail_price_box2">
                                <!--{if $tpl_class_cartype_flg1==1}-->
                                    <font color="black" size=2>車種<br></font>
                                <!--{else}-->
                                    <font color="black" size=2><!--{$tpl_class_name1}--><br></font>
                                <!--{/if}-->
                                <select name="classcategory_id1" class="box250">
                                    <!--{html_options options=$arrClassCat1 selected=$arrForm.classcategory_id1.value}-->
                                </select>
                                <!--{if $arrErr.classcategory_id1 != ""}-->
                                    <br /><span class="attention"><!--{$arrErr.classcategory_id1}--></span>
                                <!--{/if}-->
                            </div>
                        <!--{/if}-->
                    <!--{/if}-->
                    <!--{if $tpl_classcat_find2 != ""}-->
                        <!--{if $tpl_class_name2 == "JBステンプレート"}-->
                            <input type="hidden" name="getClassId2" value="<!--{$tpl_class_id2}-->" />
                            <div id="detail_price_box2" style="font-size:14px;">
                                <font color="black" size=2>数値(cm)を入力して下さい<br></font>
                                <input type="text" id="getJBSize" name="JB_Size" value="" size="25px" /> cm
                                <!--{if $arrErr.JBSize != ""}-->
                                    <br/><span class="attention"><!--{$arrErr.JBSize}--></span>
                                <!--{/if}-->
                            </div>
                        <!--{elseif $tpl_cloth_flg2 == 1}-->
                            <div id="detail_price_box2">
                                <font color="black" size=2>生地<br></font>
                                <input type="text" id="getText" name="doroyoke" value="選択して下さい" size="25px" readonly/>
                                <b><a href="../../user_data/kinkazan.php?p_id=<!--{$tpl_product_id}-->&cat_find=2" target="window_name" 
                                      onclick="disp('../../user_data/kinkazan.php?p_id=<!--{$tpl_product_id}-->&cat_find=2')">生地を選ぶ</a></b>
                                <!--{if $arrErr.classcategory_id2 != ""}-->
                                    <font size="4"><br /><span class="attention">※ 生地を選択して下さい</span></font>
                                <!--{/if}-->
                            </div>
                        <!--{else}-->
                            <div id="detail_price_box2">
                                <!--{if $tpl_class_cartype_flg2==1}-->
                                    <font color="black" size=2>車種<br></font>
                                <!--{else}-->
                                    <font color="black" size=2><!--{$tpl_class_name2}--><br></font>
                                <!--{/if}-->
                                <select name="classcategory_id2" class="box250">
                                    <option label="選択して下さい" value="__unselected">選択して下さい</option>
                                    <!--{html_options options=$arrClassCat2 selected=$arrForm.classcategory_id2.value}-->
                                </select>
                                <!--{if $arrErr.classcategory_id2 != ""}-->
                                    <br /><span class="attention"><!--{$arrErr.classcategory_id2}--></span>
                                <!--{/if}-->
                            </div>
                        <!--{/if}-->
                    <!--{/if}-->
                    <!--{* セミオーダー用フレンジフリルカラー *}-->
                    <!--{if $semi_order_flg == 1}-->
                        <input type="hidden" id="getSemiOptionId" name="semi_option_id" value="" />
                        <div id="detail_price_box2">
                            <font color="black" size=2>フレンジフリルカラー<br></font>
                            <input type="text" id="getSemiOptionName" name="semi_optionName" value="選択してください" size="25px" readonly/>
                            <b><a href="../../user_data/semi_option.php" target="window_name" onClick="disp('../../user_data/semi_option.php')">フリルカラーを選ぶ</a></b>
                            <!--{if $arrErr.semi_option_id != ""}-->
                                <br/><span class="attention"><!--{$arrErr.semi_option_id}--></span>
                            <!--{/if}-->
                        </div>
                    <!--{/if}-->
                    <!--{* 切り売り製品 *}-->
                    <!--{if $sell_piece_flg == 1}-->
                        <div id="detail_price_box2">
                            <font color="black" size=2>切り売りサイズ(m単位)<br></font>
                            <input type="text" name="sell_piece_size" value="<!--{$arrForm.sell_piece_size.value|default:1|h}-->" size="25px" />&nbsp;m
                            <!--{if $arrErr.sell_piece_size != ""}-->
                                <br/><span class="attention"><!--{$arrErr.sell_piece_size}--></span>
                            <!--{/if}-->
                        </div>
                    <!--{/if}-->
                    <div id="detail_price_box3" <!--{*class="cart_area clearfix"*}-->>
                        <input type="hidden" name="mode" value="cart" />
                        <input type="hidden" name="product_id" value="<!--{$tpl_product_id}-->" />
                        <input type="hidden" name="product_class_id" value="<!--{$tpl_product_class_id}-->" id="product_class_id" />
                        <input type="hidden" name="favorite_product_id" value="" />

                        <!--{if $tpl_stock_find}-->
                            <table><tr>
                                <!--{if $sell_piece_flg != 1}-->
                                <!--★数量★-->
                                <td class="quantity">
                                    <input type="text"
                                           name="quantity" value="<!--{$arrForm.quantity.value|default:1|h}-->"
                                           size="3" maxlength="10" style="<!--{$arrErr.quantity|sfGetErrorColor}-->"
                                    />
                                </td>
                                <td class="unit">
                                    <!--{$valUnit|escape}-->
                                </td>
                                <!--{/if}-->

                                <td class="cartin">
                                    <div class="cartin_btn">
                                        <div id="cartbtn_default">
                                            <!--★カゴに入れる★-->
                                            <a href="javascript:void(document.form1.submit())"><img src="<!--{$TPL_URLPATH}-->img/detail/detail_cart.gif" alt="カゴに入れる" name="cart" id="cart" /></a>
                                        </div>
                                    </div>
                                </td>
                            </tr></table>
                            <!--{if $arrErr.quantity != ""}-->
                                 <br /><span class="attention"><!--{$arrErr.quantity}--></span>
                            <!--{/if}-->
                        <!--{else}-->
                            <div class="attention">申し訳ございませんが、只今品切れ中です。</div>
                        <!--{/if}-->
                    </div>
                <!--{/strip}--></div><!--{* //detail_price *}-->
            </form>
            <!--★お気に入り登録★-->
            <!--{if $smarty.const.OPTION_FAVORITE_PRODUCT == 1 && $tpl_login === true}-->
                <div class="add_favorite">
                    <!--{assign var=add_favorite value="add_favorite`$product_id`"}-->
                    <!--{if $arrErr[$add_favorite]}-->
                        <div class="attention"><!--{$arrErr[$add_favorite]}--></div>
                    <!--{/if}-->
                    <!--{if !$is_favorite}-->
                        <img src="<!--{$TPL_URLPATH}-->img/detail/detail_icon2.gif" alt="お気に入りに追加" name="add_favorite_product" id="add_favorite_product" />
                        <a href="javascript:fnChangeAction('?product_id=<!--{$arrProduct.product_id|h}-->');
                                            fnModeSubmit('add_favorite','favorite_product_id','<!--{$arrProduct.product_id|h}-->');"
                        >お気に入りに追加する</a>
                    <!--{else}-->
                        <img src="<!--{$TPL_URLPATH}-->img/detail/detail_icon2.gif" alt="お気に入り登録済" name="add_favorite_product" id="add_favorite_product" />
                        お気に入りに追加済み
                        <script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery.tipsy.js"></script>
                        <script type="text/javascript">
                            var favoriteButton = $("#add_favorite_product");
                            favoriteButton.tipsy({gravity: $.fn.tipsy.autoNS, fallback: "お気に入りに登録済み", fade: true });
                            <!--{if $just_added_favorite == true}-->
                            favoriteButton.load(function(){$(this).tipsy("show")});
                            $(function(){
                                var tid = setTimeout('favoriteButton.tipsy("hide")',5000);
                            });
                            <!--{/if}-->
                        </script>
                    <!--{/if}-->
                </div>
            <!--{/if}-->
            <div class="send_back">
                <img width="18" height="15" id="not" name="not" alt="返品" src="<!--{$TPL_URLPATH}-->img/detail/detail_icon3.gif">
                <a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php#sendback">返品・交換について</a>
            </div>
        </div><!--{* //detailrightblock *}-->
    </div>
</div>
<!--詳細ここまで-->
<!--{* オペビルダー用 *}-->
<!--{if "sfViewDetailOpe"|function_exists === TRUE}-->
    <!--{include file=`$smarty.const.MODULE_PATH`mdl_opebuilder/detail_ope_view.tpl}-->
<!--{/if}-->

<div class="send_free">
    <img width="710" height="22" alt="free" src="<!--{$TPL_URLPATH}-->img/common/send_free.gif">
</div>
