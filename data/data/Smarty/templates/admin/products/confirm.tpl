<!--{*
/*
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
 */
*}-->

<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="complete" />
<!--{foreach key=key item=item from=$arrSearchHidden}-->
    <!--{if is_array($item)}-->
        <!--{foreach item=c_item from=$item}-->
            <input type="hidden" name="<!--{$key|h}-->[]" value="<!--{$c_item|h}-->" />
        <!--{/foreach}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key|h}-->" value="<!--{$item|h}-->" />
    <!--{/if}-->
<!--{/foreach}-->
<!--{foreach key=key item=item from=$arrForm}-->
    <!--{if $key == 'product_status' || $key == 'event_flg'}-->
        <!--{foreach item=statusVal from=$item}-->
            <input type="hidden" name="<!--{$key}-->[]" value="<!--{$statusVal|h}-->" />
        <!--{/foreach}-->
    <!--{elseif $key == 'arrCategoryId'}-->
        <!--{* nop *}-->
    <!--{elseif $key == 'arrFile'}-->
        <!--{* nop *}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key}-->" value="<!--{$item|h}-->" />
    <!--{/if}-->
<!--{/foreach}-->
<div id="products" class="contents-main">

    <table>
        <tr>
            <th>商品名</th>
            <td>
                <!--{$arrForm.name|h}-->
            </td>
        </tr>
        <tr>
            <th>商品カテゴリ</th>
            <td>
                <!--{section name=cnt loop=$arrForm.arrCategoryId}-->
                    <!--{assign var=key value=$arrForm.arrCategoryId[cnt]}-->
                    <!--{$arrCatList[$key]|sfTrim}--><br />
                <!--{/section}-->
            </td>
        </tr>
        <tr>
            <th>公開・非公開</th>
            <td>
                <!--{$arrDISP[$arrForm.status]}-->
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td>
                <!--{foreach from=$arrForm.product_status item=status}-->
                    <!--{if $status != ""}-->
                        <img src="<!--{$TPL_URLPATH_DEFAULT}--><!--{$arrSTATUS_IMAGE[$status]}-->">
                    <!--{/if}-->
                <!--{/foreach}-->
            </td>
        </tr>

        <!--{if $arrForm.has_product_class != true}-->
            <tr>
                <th>商品種別</th>
                <td>
                    <!--{$arrProductType[$arrForm.product_type_id]}-->
                </td>
            </tr>
            <tr>
                <th>ダウンロード商品ファイル名</th>
                <td>
                    <!--{$arrForm.down_filename|h}-->
                </td>
            </tr>
            <tr>
                <th>ダウンロード商品用<BR />ファイル</th>
                <td>
                    <!--{if $arrForm.down_realfilename != ""}-->
                        <!--{$arrForm.down_realfilename|h}-->
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>商品コード</th>
                <td>
                    <!--{$arrForm.product_code|h}-->
                </td>
            </tr>
            <tr>
                <th><!--{$smarty.const.NORMAL_PRICE_TITLE}--></th>
                <td>
                    <!--{if strlen($arrForm.price01) >= 1}--><!--{$arrForm.price01|h}--> 円<!--{/if}-->
                </td>
            </tr>
            <tr>
                <th><!--{$smarty.const.SALE_PRICE_TITLE}--></th>
                <td>
                    <!--{if strlen($arrForm.price02) >= 1}--><!--{$arrForm.price02|h}--> 円<!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>在庫数</th>
                <td>
                    <!--{if $arrForm.stock_unlimited == 1}-->
                        無制限
                    <!--{else}-->
                        <!--{$arrForm.stock|h}-->
                    <!--{/if}-->
                </td>
            </tr>
        <!--{/if}-->

        <tr>
            <th>商品送料</th>
            <td>
                <!--{if strlen($arrForm.deliv_fee) >= 1}--><!--{$arrForm.deliv_fee|h}--> 円<!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>ポイント付与率</th>
            <td>
                <!--{if strlen($arrForm.point_rate) >= 1}--><!--{$arrForm.point_rate|h}--> ％<!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>発送日目安</th>
            <td>
                <!--{$arrDELIVERYDATE[$arrForm.deliv_date_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>販売制限数</th>
            <td>
                <!--{$arrForm.sale_limit|default:'無制限'|h}-->
            </td>
        </tr>
        <tr>
            <th>メーカー</th>
            <td>
                <!--{$arrMaker[$arrForm.maker_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>メーカーURL</th>
            <td style="word-break: break-all;">
                <!--{$arrForm.comment1|h}-->
            </td>
        </tr>
        <tr>
            <th>検索ワード</th>
            <td>
                <!--{$arrForm.comment3|h}-->
            </td>
        </tr>
        <tr>
            <th>備考欄(SHOP専用)</th>
            <td>
                <!--{$arrForm.note|h|nl2br}-->
            </td>
        </tr>
        <tr>
            <th>一覧-メインコメント</th>
            <td>
                <!--{$arrForm.main_list_comment|h|nl2br}-->
            </td>
        </tr>
        <tr>
            <th>詳細-メインコメント</th>
            <td>
                <!--{$arrForm.main_comment|nl2br_html}-->
            </td>
        </tr>
        <tr>
            <th>イベント登録</th>
            <td>
                <!--{foreach item=event_id from=$arrForm.event_flg}-->
                    <!--{if $event_id != ""}-->
                    <!--{$arrEVENT[$event_id]|h}-->&nbsp;
                    <!--{/if}-->
                <!--{/foreach}-->
            </td>
        </tr>
        <tr>
            <th>セミオーダー商品</th>
            <td>
                <!--{$arrOPTIONITEM[$arrForm.semi_order_made_flg]|h}-->
            </td>
        </tr>
        <tr>
            <th>セミオーダーオプション商品</th>
            <td>
                <!--{$arrOPTIONITEM[$arrForm.option_item_flg]|h}-->
            </td>
        </tr>
        <tr>
            <th>切り売り可能商品</th>
            <td>
                <!--{$arrOPTIONITEM[$arrForm.sell_piece_flg]|h}-->
            </td>
        </tr>
        <tr>
            <th>表示単位</th>
            <td>
                <!--{$arrUNIT[$arrForm.unit_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>一覧-メイン画像</th>
            <td>
                <!--{assign var=key value="main_list_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>詳細-メイン画像</th>
            <td>
                <!--{assign var=key value="main_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>詳細-メイン拡大画像</th>
            <td>
                <!--{assign var=key value="main_large_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>

        <!--{* オペビルダー用 *}-->
        <!--{if "sfViewAdminOpe"|function_exists === TRUE}-->
            <!--{include file=`$smarty.const.MODULE_REALDIR`mdl_opebuilder/admin_ope_view.tpl}-->
        <!--{/if}-->

        <!--{section name=cnt loop=$smarty.const.PRODUCTSUB_MAX}-->
            <!--▼商品<!--{$smarty.section.cnt.iteration}-->-->
            <tr>
                <th>詳細-サブタイトル（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_title`$smarty.section.cnt.iteration`"}-->
                    <!--{$arrForm[$key]|h}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブコメント（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_comment`$smarty.section.cnt.iteration`"}-->
                    <!--{$arrForm[$key]|nl2br_html}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブ画像（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_image`$smarty.section.cnt.iteration`"}-->
                    <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                        <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブ拡大画像（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_large_image`$smarty.section.cnt.iteration`"}-->
                    <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                        <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                    <!--{/if}-->
                </td>
            </tr>
            <!--▲商品<!--{$smarty.section.cnt.iteration}-->-->
        <!--{/section}-->

        <tr>
            <th>表の色選択</th>
            <td>
                <!--{$arrClass[$arrForm.body_color_class_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>裏の色選択</th>
            <td>
                <!--{$arrClass[$arrForm.back_color_class_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>フチの色選択</th>
            <td>
                <!--{$arrClass[$arrForm.edge_color_class_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>フチのサイズ選択</th>
            <td>
                <!--{$arrClass[$arrForm.edge_size_class_id]|h}-->
            </td>
        </tr>

        <!--{if $smarty.const.OPTION_RECOMMEND == 1}-->
            <!--▼関連商品-->
            <!--{section name=cnt loop=$smarty.const.RECOMMEND_PRODUCT_MAX}-->
            <!--{assign var=recommend_no value="`$smarty.section.cnt.iteration`"}-->
                <tr>
                    <th>関連商品(<!--{$smarty.section.cnt.iteration}-->)<br />
                        <!--{if $arrRecommend[$recommend_no].product_id|strlen >= 1}-->
                            <img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$arrRecommend[$recommend_no].main_list_image|sfNoImageMainList|h}-->&amp;width=65&amp;height=65" alt="<!--{$arrRecommend[$recommend_no].name|h}-->">
                        <!--{/if}-->
                    </th>
                    <td>
                        <!--{if $arrRecommend[$recommend_no].product_id|strlen >= 1}-->
                            商品コード:<!--{$arrRecommend[$recommend_no].product_code_min}--><br />
                            商品名:<!--{$arrRecommend[$recommend_no].name|h}--><br />
                            コメント:<br />
                            <!--{$arrRecommend[$recommend_no].comment|h|nl2br}-->
                        <!--{/if}-->
                    </td>
                </tr>
            <!--{/section}-->
            <!--▲関連商品-->
        <!--{/if}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>
