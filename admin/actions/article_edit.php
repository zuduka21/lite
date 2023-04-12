<?php

$article = false;

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {

    $id = (int) $_GET['id'];
    $article = $A->getArticle($id);
    if($id > 2000 || $U->isAuthor($U->getRoleId($article->user_id))):
        $block = !empty($article->blocks) ? $article->blocks[0] : false;
        if(!$block):
            $mysql->runQuery("INSERT INTO `blocks` SET `article_id` = '{$id}', `sort` = 1, `type` = 9");
            $block_id = $mysql->getLastID();
            $block = $A->getBlock($block_id);
        endif;
    else:
        $block = isset($_GET['block_id']) ? $A->getBlock($_GET['block_id']) : false;
    endif;
}

if (isset($_GET['action']) && $_GET['action'] == 'publish' && isset($_GET['id'])) {

    $id = (int) $_GET['id'];
    $A->publishArticle($id);

    redirectTo(getBackUrl());
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {

    $id = (int) $_GET['id'];
    $A->deleteArticle($id);

    redirectTo(getUrl('page=new'));

}

if (isset($_GET['action']) && $_GET['action'] == 'delete_block' && isset($_GET['id']) && isset($_GET['block_id'])) {

    $id = (int) $_GET['id'];
    $A->deleteBlock($_GET['block_id']);

    redirectTo(getBackUrl());

}

if (isset($_POST['action']) && $_POST['action'] == 'edit' && isset($_POST['id'])) {

    //print_r($_FILES); die();

    $no_error = true;

    $article_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $block_id = isset($_POST['block_id']) ? (int) $_POST['block_id'] : 0;
    $is_new = $block_id == 0 ? true : false;
    $name = isset($_POST['name']) ? $mysql->escapeString($_POST['name']) : '';
    $info = isset($_POST['info']) ? $mysql->escapeString($_POST['info']) : '';
    $sort = isset($_POST['sort']) ? $mysql->escapeString($_POST['sort']) : '';
    $type = isset($_POST['type']) ? $mysql->escapeString($_POST['type']) : '';
    $url = isset($_POST['url']) ? $mysql->escapeString($_POST['url']) : '';

    if ($type == 1 && $name == '') {
        setError("Название не может быть пустым");
        $no_error = false;
    }

    if ($no_error) {
        if ($block_id > 0) {
            $mysql->runQuery("UPDATE `blocks` SET `article_id` = '{$article_id}', `name` = '{$name}', `info` = '{$info}', `sort` = '{$sort}', `type` = '{$type}', `url` = '{$url}' WHERE `id` = '{$block_id}'");
        } else {
            if (!isset($_FILES['photo']) || count($_FILES['photo']['tmp_name']) <= 1) {
                $mysql->runQuery("INSERT INTO `blocks` SET `article_id` = '{$article_id}', `name` = '{$name}', `info` = '{$info}', `sort` = '{$sort}', `type` = '{$type}', `url` = '{$url}'");
                $block_id = $mysql->getLastID();
            } else {
                foreach ($_FILES['photo']['tmp_name'] as $k=>$v) {
                    $mysql->runQuery("INSERT INTO `blocks` SET `article_id` = '{$article_id}', `name` = '{$name}', `info` = '{$info}', `sort` = '{$sort}', `type` = '{$type}'");
                    $block_id = $mysql->getLastID();
                    if (isset($_FILES['photo']['tmp_name'][$k]) && $_FILES['photo']['tmp_name'][$k] != '' && $block_id > 0) {
                        $uploaddir = __DIR__ . "/../img/{$article_id}";
                        @mkdir($uploaddir);
                        $uploadfile = $uploaddir . "/{$block_id}.jpg";

                        if (move_uploaded_file($_FILES['photo']['tmp_name'][$k], $uploadfile)) {
                            @unlink($uploaddir . "/{$block_id}_l.jpg");
                            @unlink($uploaddir . "/{$block_id}_s.jpg");
                        } else {
                            setError("Не удалось загрузить файл");
                        }
                    }
                    $sort += 10;
                }
            }
        }
        $mysql->runQuery("UPDATE `articles` SET `is_changed` = 1 WHERE `id` = '{$article_id}'");

        if (count($_FILES['photo']['tmp_name']) <= 1 && isset($_FILES['photo']['tmp_name'][0]) && $_FILES['photo']['tmp_name'][0] != '' && $block_id > 0) {
            $uploaddir = __DIR__ . "/../img/{$article_id}";
            @mkdir($uploaddir);
            $uploadfile = $uploaddir . "/{$block_id}.jpg";

            if (move_uploaded_file($_FILES['photo']['tmp_name'][0], $uploadfile)) {
                @unlink($uploaddir . "/{$block_id}_l.jpg");
                @unlink($uploaddir . "/{$block_id}_s.jpg");
            } else {
                setError("Не удалось загрузить файл");
            }
        }
        //$mysql->runQuery("DELETE FROM `images` WHERE `article_id` = '{$article_id}'");

        setSuccess('Изменения успешно сохранены' .  $uploaddir . "/{$block_id}_l.jpg");
    }

    $article = $A->getArticle($article_id);
    $block = $is_new ? false : $A->getBlock($block_id);

}

if (isset($_POST['action']) && $_POST['action'] == 'edit_post' && isset($_POST['id'])) {
    $no_error = true;

    $article_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $block_id = isset($_POST['block_id']) ? (int) $_POST['block_id'] : 0;
    $is_new = $block_id == 0 ? true : false;
    $name = isset($_POST['name']) ? $mysql->escapeString($_POST['name']) : '';
    $info = isset($_POST['info']) ? $mysql->escapeString($_POST['info']) : '';
    $sort = isset($_POST['sort']) ? $mysql->escapeString($_POST['sort']) : '';
    $type = isset($_POST['type']) ? $mysql->escapeString($_POST['type']) : '';
    $url = isset($_POST['url']) ? $mysql->escapeString($_POST['url']) : '';
    $photo_source = isset($_POST['url']) ? $mysql->escapeString($_POST['url']) . '-foto' : '';
    //$info = str_replace(",", ", ", $info);
    //$info = str_replace(",  ", ", ", $info);
    //$info = str_replace(",  ", ", ", $info);
    
    $meta_title = isset($_POST['meta_title'])  ? $mysql->escapeString($_POST['meta_title']) : '';
    $meta_description = isset($_POST['meta_description'])  ? $mysql->escapeString($_POST['meta_description']) : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    $is_special = isset($_POST['is_special']) ? (int)$_POST['is_special'] : 0;
    $is_for_zen = isset($_POST['is_for_zen']) ? (int)$_POST['is_for_zen'] : 0;
    $is_yandex = isset($_POST['is_yandex']) ? (int)$_POST['is_yandex'] : 0;

    if($U->isEditor()){
        $is_reviewed = 1;
    }else{
        $is_reviewed = !empty($article) ? $article->is_reviewed : 0;
    }

    if ($block_id > 0) {
        $mysql->runQuery("UPDATE `blocks` SET `article_id` = '{$article_id}', `name` = '', `info` = '{$info}', `sort` = 1, `type` = 9, `url` = '' WHERE `id` = '{$block_id}'");
    }
    $mysql->runQuery("UPDATE `articles` SET `name` = '{$name}', `meta_title` = '{$meta_title}', `meta_description` = '{$meta_description}', `url` = '{$url}', `photo_source` = '{$photo_source}',`category_id` = '{$category_id}', `is_special` = '{$is_special}', `is_for_zen` = '{$is_for_zen}', `is_yandex` = '{$is_yandex}', `is_reviewed` = '{$is_reviewed}', `is_changed` = 1 WHERE `id` = '{$article_id}'");

    $directory = __DIR__ . "/../img/{$article_id}/";
    $images = glob($directory . "[0-9]*.jpg");

    foreach($images as $k => $image)
    {
        $src = __DIR__ . "/../img/{$article_id}/{$k}.jpg";
        $dst_l = __DIR__ . "/../img/{$article_id}/{$k}_l.jpg";
        $dst_s = __DIR__ . "/../img/{$article_id}/{$k}_s.jpg";

        if (file_exists($src)) {
            $image = new SimpleImage();
            $image->load($src);
            $image->resizeToWidth(450);
            $image->save($dst_s, IMAGETYPE_JPEG, 85);

            $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg($dst_s));
        }

        if (file_exists($src)) {
            $image = new SimpleImage();
            $image->load($src);
            $image->resizeToWidth(750);
            $image->save($dst_l, IMAGETYPE_JPEG, 85);

            $compressed_jpg_content = shell_exec("jpegoptim --max=75 --strip-all --all-progressive " . escapeshellarg($dst_l));
        }
        //$mysql->runQuery("DELETE FROM `images` WHERE `article_id` = '{$article_id}' AND `photo_id` = '{$k}'");
    }
    //$mysql->runQuery("DELETE FROM `images` WHERE `article_id` = '{$article_id}'");

    setSuccess('Изменения успешно сохранены');


    redirectTo(getBackUrl());

}

if (isset($_GET['action']) && $_GET['action'] == 'autosave' && isset($_POST['id'])) {

    $article_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $block_id = isset($_POST['block_id']) ? (int) $_POST['block_id'] : 0;
    $is_new = $block_id == 0 ? true : false;
    $info = isset($_POST['info']) ? $mysql->escapeString($_POST['info']) : '';
    $name = isset($_POST['name']) ? $mysql->escapeString($_POST['name']) : '';
    $sort = isset($_POST['sort']) ? (int)$_POST['sort'] : 0;
    $type = isset($_POST['type']) ? (int)$_POST['type'] : 0;
    if ($block_id > 0) {
        $mysql->runQuery("UPDATE `blocks` SET `article_id` = '{$article_id}', `info` = '{$info}', `sort` = '{$sort}', `type` = '{$type}' WHERE `id` = '{$block_id}'");
        $mysql->runQuery("UPDATE `articles` SET `name` = '{$name}' WHERE `id` = '{$article_id}'");
    }

    exit();

}

if (isset($_GET['action']) && $_GET['action'] == 'upload' && isset($_POST['id'])) {
    $article_id  = $_POST['id'];
    $url  = $_POST['url'];
    $data = [];
    $uploaddir = __DIR__ . "/../img/{$article_id}";

    $images = count(glob($uploaddir . "/*[0-9].jpg"));

    $mysql->runQuery("DELETE FROM `images` WHERE `article_id` = '{$article_id}' AND `photo_id` = '{$images}'");

    @mkdir($uploaddir);
    $error = false;
    foreach ($_FILES['file']['tmp_name'] as $k=>$v) {
        if (isset($_FILES['file']['tmp_name'][$k]) && $_FILES['file']['tmp_name'][$k] != '') {
            $uploadfile = $uploaddir . "/" . $images . ".jpg";

            header('Content-type: application/json');
            if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
                $data[] = [
                    'url' => getMainURL("photo/foto-{$article_id}-{$images}.jpg?".date('U')),
                    'id' => $images
                ];
            }
            $images++;
        }else {
            $error = true;
        }
    }
    if(!$error){
        echo json_encode($data);
    } else {
        echo json_encode(['error' => true, "message" => "Ошибка загрузки"]);
    }

    exit();

}

if (isset($_GET['action']) && $_GET['action'] == 'upload' && isset($_POST['id'])) {
    $article_id  = $_POST['id'];
    $url  = $_POST['url'];
    $data = [];
    $uploaddir = __DIR__ . "/../img/{$article_id}";

    $images = count(glob($uploaddir . "/*[0-9].jpg"));

    $mysql->runQuery("DELETE FROM `images` WHERE `article_id` = '{$article_id}' AND `photo_id` = '{$images}'");

    @mkdir($uploaddir);

    foreach ($_FILES['file']['tmp_name'] as $k=>$v) {
        if (isset($_FILES['file']['tmp_name'][$k]) && $_FILES['file']['tmp_name'][$k] != '') {
            $uploadfile = $uploaddir . "/" . $images . ".jpg";

            header('Content-type: application/json');
            if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
                $data[] = [
                    'url' => getMainURL("photo/foto-{$article_id}-{$images}.jpg?".date('U')),
                    'id' => $images
                ];
            }
            $images++;
        }else {
            $error = true;
        }
    }
    if(!$error){
        echo json_encode($data);
    } else {
        echo json_encode(['error' => true, "message" => "Ошибка загрузки"]);
    }

    exit();

}

if (isset($_GET['action']) && $_GET['action'] == 'load_microdata' && isset($_GET['article_id']) && isset($_POST['type'])) {
    $type = $_POST['type'];
    $article_id = $_GET['article_id'];
    $template_name = getTemplateName($type);
    $block = (object) $A->getBlockByType($article_id, $type);
    if (!empty($block)):
        $data = (object) $block->info;
    endif;
    //$data = json_last_error ( );
    $response = include(__DIR__ . '../../pages/' . $template_name);
    die();
}

if (isset($_GET['action']) && $_GET['action'] == 'save_microdata' && isset($_GET['article_id']) && isset($_POST['type'])) {
    $type = $data['type'] = $_POST['type'];
    $article_id = $data['article_id'] = $_GET['article_id'];

    // Get form data based on microdata type
    switch ($type):
        case(20):
            $json['total_time'] = $_POST['total_time'];
            $json['description'] = $_POST['description'];
            $json['supplies'] = explode( "\n", str_replace( "\r", "", $_POST['supplies'] ) );
            $json['tools'] = explode( "\n", str_replace( "\r", "", $_POST['tools'] ) );
            $json['steps'] = explode( "\n", str_replace( "\r", "", $_POST['steps'] ) );
            break;
        case(21):
            $json['category'] = $_POST['category'];
            $json['description'] = $_POST['description'];
            $json['prep_time'] = $_POST['prep_time'];
            $json['cook_time'] = $_POST['cook_time'];
            $json['cook_yield'] = $_POST['cook_yield'];
            $json['ingredients'] = explode( "\n", str_replace( "\r", "", $_POST['ingredients'] ) );
            $json['instructions'] = explode( "\n", str_replace( "\r", "", $_POST['instructions'] ) );
            $json['step_photos'] = explode( "\n", str_replace( "\r", "", $_POST['step_photos'] ) );
            $json['rating_value'] = $_POST['rating_value'];
            $json['rating_count'] = $_POST['rating_count'];
            break;
        default:
            header('Content-type: application/json');
            echo json_encode('Не был указан тип микроразметки, изменения не сохранены');
            die();
            break;
    endswitch;
    $data['text'] = json_encode($json, JSON_UNESCAPED_UNICODE);
    $result = $A->saveMicrodata($data);
    header('Content-type: application/json');
    if($result):
        $A->purgeCache($data['article_id']);
        echo json_encode('Микроразметка успешно обновлена');
    else:
        echo json_encode('Произошла ошибка, попробуйте еще раз');
    endif;
    die();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove_image' && isset($_GET['article_id']) && isset($_POST['id'])) {
    $article_id = $_GET['article_id'];
    $image_id = $_POST['id'];
    $new = (!(int)$_POST['replace_with'] ? (int)$_POST['replace_with'] : (int)$_POST['replace_with'] - 1);
    $replace_with = (int)$_POST['id'] + 1;
    $response = [];
    $images = (int)count(glob(__DIR__ . "/../img/{$article_id}/*[0-9].jpg"));

    // Remove image start
    if($images !== 1):
        $filename = __DIR__ . "/../img/{$article_id}/{$image_id}.jpg";
        $filename_s = __DIR__ . "/../img/{$article_id}/{$image_id}_s.jpg";
        $filename_l = __DIR__ . "/../img/{$article_id}/{$image_id}_l.jpg";
    else:
        $filename = __DIR__ . "/../img/{$article_id}/0.jpg";
        $filename_s = __DIR__ . "/../img/{$article_id}/0_s.jpg";
        $filename_l = __DIR__ . "/../img/{$article_id}/0_l.jpg";
    endif;
    // Remove image end

    @unlink ($filename);
    @unlink ($filename_l);
    @unlink ($filename_s);

    for ($i = $replace_with; $i < $images; $i++) {
        $new = $i - 1;
        $response[] = replaceImage($article_id, $i, $new);
    }

    header('Content-type: application/json');
    echo json_encode($response);
    die();
}
if (!$article) redirectTo(getBackUrl());

function replaceImage($article_id = 0, $old_name = 0, $new_name = 0)
{
    @rename(__DIR__ . "/../img/{$article_id}/{$old_name}.jpg", __DIR__ . "/../img/{$article_id}/".$new_name.".jpg");
    @rename(__DIR__ . "/../img/{$article_id}/{$old_name}.jpg", __DIR__ . "/../img/{$article_id}/".$new_name."_s.jpg");
    @rename(__DIR__ . "/../img/{$article_id}/{$old_name}.jpg", __DIR__ . "/../img/{$article_id}/".$new_name."_l.jpg");
    if(file_exists(__DIR__ . "/../img/{$article_id}/{$new_name}.jpg")):
        return [
            'url' => getMainURL("photo/foto-{$article_id}-{$new_name}.jpg?".date('U')),
            'id' =>  $new_name,
            'replace_with' => $old_name
        ];
    endif;
}

function getTemplateName($type = 0)
{
    switch ((int)$type):
        case (20):
            return 'microdata_howto.php';
        case (21):
            return 'microdata_recipe.php';
    endswitch;
}
