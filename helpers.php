<?php 


/**
 * Helper fn to download a remote image from the blog.
 * @param string $img_src : the given remote image (ie. http:// ... .imageeeen.png)
 * returns string|false : if ok, returns the path where the image was saved (ie )
 */
function download_image($img_src) {
    // $img_src = 'https://1.bp.blogspot.com/-DWrwvndh9r8/YKhOeB2OQnI/AAAAAAAAzBo/PG2FPByPGQM7csRc472pedF34Ol0wRefwCLcBGAsYHQ/w400-h250/xeen_948.png';
    $download_folder = 'downloads' . DIRECTORY_SEPARATOR; // TODO: make global const
    $basename = basename ( $img_src );
    $new_path = $download_folder . $basename;
    // this works ok in my local server. Not so sure in others.
    $s = copy($img_src, $new_path);
    if ($s) return $new_path;
    return false;
}

/**
 * Does what is says. It's like document.querySelectorAll('.nameofclass'), but in php
 */
function getElementsByClass($Dom, $DomXPath, $classname, $o = []){
    $options = array_merge([ 
        'returnFirst' => true,
        'returnContent' => false,
        'returnHTML' => false,
    ], $o);

    // the return image is what we will return in the end. Intially is the DOM item, depending on the options, we will transform it.
    $return = $DomXPath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

    // if we want the text content or the HTML it means that we want only the first item, not all
    if (!empty(array_intersect($options, ['returnContent', 'returnHTML'])))
        $options['returnFirst'] = true;

    if ($options['returnFirst']) {
        $return = ($return->length)? $return->item(0) : null;
    }

    // returns string without html tags
    if ($options['returnContent'] && $return) {
        $return = $return->textContent;
    }

    // returns string with html tags
    if ($options['returnHTML'] && $return) {
        $return = $Dom->saveHTML($return);
    }

    return $return;
}

/**
 * useful for debugging
 */
function dd($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}