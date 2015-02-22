=== Save Yupoo Imgs To Local ===
Contributors: xiaoxu125634
Donate link: http://www.brunoxu.com/
Tags: yupoo, images, save yupoo images, 又拍图片下载, 又拍图片保存, 又拍图片流量超过
Requires at least: 3.0
Tested up to: 4.1.1
Stable tag: trunk

保存又拍(yupoo)图片到本地目录，全文查找图片并替换

== Description ==

[插件首页](http://www.brunoxu.com/save-yupoo-imgs-to-local.html) | [插件作者](http://www.brunoxu.com/)

yupoo免费用户支持100M空间，每月1G流量，使用已经有两年了，一直使用挺正常的，但是从上个月(14年7月)开始，以前只用三四百兆的流量，猛的激增，基本上半个月左右就用完了，或者时间更短，因为免费用户只能看到本月总的使用流量数，不能看每天使用多少，也看不到那个域名占用的流量多（因为免费用户无法防盗链，可能图片被其他网站拿过去用了，占用了我的流量）。

流量用完导致部分文章图片不能正常显示，没办法只能准备换地方存图片，但是更坑爹的是，yupoo后台没有提供下载图片的地方，批量下载是付费会员的专属功能。只能想想其他办法解决这个问题了。

然后就做了这个插件“Save Yupoo Imgs To Local”，用来在文章显示的之前把yupoo图片全部下载到本地，然后把图片地址替换成本地地址，这样文章中的图片就能正常显示了。

当然能做出这个功能的插件，还有个发现做前提，本来以为流量超了，怎么样都看不到原图了，只能到yupoo管理中心才能看到了吧。其实不是这样，图片url在新窗口中是可以显示的，也就是说yupoo控制了图片request的referer，没有referer的还能正常显示，这也是插件能下载到原图的前提。如果哪天yupoo关闭了这个途径，插件自然也会失效了。

要处理所有的文章的yupoo图片，需要知道哪些文章含有yupoo图片。sql支持： SELECT * FROM `wp_posts` WHERE post_content LIKE '%http://pic.yupoo.com/%';

全部文章处理完毕之后，批量更新文章中图片url地址，sql支持： UPDATE `wp_posts` SET post_content=REPLACE(post_content,'http://pic.yupoo.com/','/wp-content/uploads/yupoo_imgs/') WHERE post_content LIKE '%http://pic.yupoo.com/%';

需要注意的是，在插件转存图片的时候，会有图片不能完整下载的情况，如果发现了，要在服务器端删掉下载不完整的图片，再刷一次页面，让插件重新下载一般就会成功了。

== Installation ==

1. Upload `save-yupoo-imgs-to-local` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress background.

== Changelog ==

= 1.0 =
* 2014-08-28
* Plugin released.
