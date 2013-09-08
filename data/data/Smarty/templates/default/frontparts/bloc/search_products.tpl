<div id="header_search">
    <div id="header_search_body">
        <!--検索フォーム-->
            <form name="search_form" id="search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <table>
                <tbody><tr>
                    <td>
                        <input type="hidden" name="mode" value="search" />
                        <select name="category_id">
                          <option value="search" label="すべての商品">商品カテゴリから探す</option>
                          <!--{html_options options=$arrCatList selected=$category_id}-->
                        </select>
                    </td>
                    <td class="search_word">
                      <input type="text" name="name" maxlength="50" size="16" value="<!--{$smarty.get.name|h}-->" />
                    </td>
                    <td class="search_btn">
                      <input type="image" name="search" alt="検索" src="<!--{$TPL_URLPATH}-->img/header/h_search.gif">
                    </td>
                </tr>
            </tbody></table>
        </form>
    </div>
</div>