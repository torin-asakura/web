<?php
/**
 * Template part for displaying posts meta.
 */

namespace YOOtheme;

$view = app(View::class);

$date = $config('~theme.post.date') ? '<span>' . get_post_date($post) . '</span>' : '';
$author = $config('~theme.post.author') ? get_post_author($post) : '';
$category = $config('~theme.post.categories') ? get_the_category_list(wp_get_list_item_separator(), '', $post) : '';
$comments = $config('~theme.post.comments') && !post_password_required($post) && (comments_open($post) || get_comments_number($post));

if ($date || $author || $category || $comments) {

    $attrs_meta['class'][] = $view->margin($config('~theme.post.meta_margin')) . ' uk-margin-remove-bottom';

    switch ($config('~theme.post.meta_style')) {

        case 'list':

            $attrs_meta['class'][] = 'uk-subnav uk-subnav-divider';
            $attrs_meta['class'][] = $config('~theme.post.header_align') ? 'uk-flex-center' : '';

            ?>
            <ul<?= $view->attrs($attrs_meta) ?>>
                <?php foreach (array_filter([$date, $author]) as $part) : ?>
                    <li><?= $part ?></li>
                <?php endforeach ?>

                <?php if ($category && count(wp_get_post_categories($post->ID)) > 1) : ?>
                    <li><span><?= $category ?></span></li>
                <?php elseif ($category) : ?>
                    <li><?= $category ?></li>
                <?php endif ?>

                <?php if ($comments) : ?>
                    <li><?php comments_popup_link() ?></li>
                <?php endif ?>
            </ul>
            <?php
            break;

        default: // sentence

            $attrs_meta['class'][] = 'uk-article-meta';
            $attrs_meta['class'][] = $config('~theme.post.header_align') ? 'uk-text-center' : '';

            ?>
            <p<?= $view->attrs($attrs_meta) ?>>
                <?php

                if ($author && $date) {
                    printf(__('Written by %s on %s.', 'yootheme'), get_post_author($post), get_post_date($post));
                } elseif ($author) {
                    printf(__('Written by %s.', 'yootheme'), get_post_author($post));
                } elseif ($date) {
                    printf(__('Written on %s.', 'yootheme'), get_post_date($post));
                }

                ?>
                <?php

                if ($category) {
                    printf(__('Posted in %1$s.', 'yootheme'), $category);
                }

                ?>
                <?php

                if ($comments) {
                    comments_popup_link();
                }

                ?>
            </p>
        <?php
    }

}
