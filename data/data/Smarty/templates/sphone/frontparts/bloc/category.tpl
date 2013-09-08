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

<!--商品カテゴリここから-->
<section id="category_area">
    <!--{*
    <h2 class="title_block">商品カテゴリ</h2>
    <nav id="categorytree">
        <ul id="categorytreelist">
            <!--{assign var=preLev value=1}-->
            <!--{assign var=firstdone value=0}-->
            <!--{section name=cnt loop=$arrTree}-->
                <!--{* インデントは Smarty 構文を優先としています。 }-->
                <!--{* カテゴリ表示・非表示切り替え }-->
                <!--{if $arrTree[cnt].view_flg != "2"}-->
                    <!--{* 表示フラグがTRUEなら表示 }-->
                    <!--{assign var=level value=`$arrTree[cnt].level`}-->
                    <!--{* level2以下なら表示（level指定可能） }-->
                    <!--{if $level <= 5 || $arrTree[cnt].display == 1}-->
                        <!--{assign var=levdiff value=`$level-$preLev`}-->
                        <!--{if $levdiff > 0}-->
                            <ul>
                        <!--{elseif $levdiff == 0 && $firstdone == 1}-->
                            </li>
                        <!--{elseif $levdiff < 0}-->
                            <!--{section name=d loop=`$levdiff*-1`}-->
                                    </li>
                                </ul>
                            <!--{/section}-->
                            </li>
                        <!--{/if}-->

                        <li class="level<!--{$level}--><!--{if in_array($arrTree[cnt].category_id, $tpl_category_id)}--> onmark<!--{/if}-->"><span class="category_header"></span><span class="category_body"><a rel="external" href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrTree[cnt].category_id}-->"<!--{if in_array($arrTree[cnt].category_id, $tpl_category_id)}--> class="onlink"<!--{/if}-->><!--{$arrTree[cnt].category_name|h}-->(<!--{$arrTree[cnt].product_count|default:0}-->)</a></span>
                        <!--{if $firstdone == 0}-->
                            <!--{assign var=firstdone value=1}-->
                        <!--{/if}-->
                        <!--{assign var=preLev value=`$level`}-->
                    <!--{/if}-->

                    <!--{* セクションの最後に閉じタグを追加 }-->
                    <!--{if $smarty.section.cnt.last}-->
                        <!--{if $preLev-1 > 0}-->
                            <!--{section name=d loop=`$preLev-1`}-->
                                    </li>
                                </ul>
                            <!--{/section}-->
                            </li>
                        <!--{else}-->
                            </li>
                        <!--{/if}-->
                    <!--{/if}-->
                <!--{/if}-->
            <!--{/section}-->
        </ul>
        <script>//<![CDATA[
            initCategoryList(); //カテゴリリストの初期化
        //]]></script>
    </nav>
    *}-->
    <nav id="category">
        <h2 class="title_block">カテゴリから選ぶ</h2>
        <dl>
            <dt class="exterior">
                <h3><span>外装から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_gaisou}-->
                    <!--{if $arrRet_gaisou[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_gaisou[cnt].category_id}-->"><!--{$arrRet_gaisou[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
        <dl>
            <dt class="illumination">
                <h3><span>電飾から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_densyoku}-->
                    <!--{if $arrRet_densyoku[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_densyoku[cnt].category_id}-->"><!--{$arrRet_densyoku[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
        <dl>
            <dt class="interior">
                <h3><span>内装から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_gaisou}-->
                    <!--{if $arrRet_naisou[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_naisou[cnt].category_id}-->"><!--{$arrRet_naisou[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
        <dl>
            <dt class="goods">
                <h3><span>ドライバー用品から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_driver}-->
                    <!--{if $arrRet_driver[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_driver[cnt].category_id}-->"><!--{$arrRet_driver[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
        <dl>
            <dt class="type">
                <h3><span>車種別から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_syasyu}-->
                    <!--{if $arrRet_syasyu[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_syasyu[cnt].category_id}-->"><!--{$arrRet_syasyu[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
        <dl>
            <dt class="business">
                <h3><span>業務用品から選ぶ</span></h3>
            </dt>
            <dd>
                <ul>
                <!--{section name=cnt loop=$arrRet_gyoumu}-->
                    <!--{if $arrRet_gyoumu[cnt].display == 1}-->
                    <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_gyoumu[cnt].category_id}-->"><!--{$arrRet_gyoumu[cnt].category_name}--></a></li>
                    <!--{/if}-->
                <!--{/section}-->
                </ul>
            </dd>
        </dl>
    </nav>
</section>
<!-- ▲カテゴリ -->