<?php

    $step_photos = !empty($data->step_photos) ? implode("\r", $data->step_photos) : '';
    if ($step_photos == '') {
        $photos = array();
        $b = (object) $A->getBlockByType($article_id, 9);
        $b = (object) $A->getBlock($b->id);
        //$step_photos = $b->id;
        
        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML('<html>' . $b->info .'</html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        $tags = $doc->getElementsByTagName('img');

        foreach ($tags as $key => $tag) {
            $class = $tag->getAttribute('class');
            if ((strpos($class, "i_result") !== false || strpos($class, "i_step") !== false) && $tag->getAttribute('src') != '') $photos[] = $tag->getAttribute('src');
        }
        
        if (count($photos) > 1) $step_photos = implode("\r", $photos);
        
    }

?>
<div class="form-group microdata-input">
    <label for="input-category">
        Категория блюда
    </label>
    <input type="text" class="form-control" id="input-category" name="category" value="<?=@$data->category?>"/>
</div>
<div class="form-group microdata-input">
    <label for="input-description">
        Описание блюда
    </label>
    <textarea class="form-control" id="input-description" name="description"><?=@$data->description?></textarea>
</div>
<div class="form-group microdata-input">
    <div class="row">
        <div class="col-md-4">
            <label for="input-prep-time">
                Подготовка
            </label>
            <select name="prep_time" id="input-prep-time" class="form-control">
                <option <?=(@$data->prep_time === '5') ? 'selected ' : '' ?>value="5">5 минут</option>
                <option <?=(@$data->prep_time === '10') ? 'selected ' : '' ?>value="10">10 минут</option>
                <option <?=(@$data->prep_time === '15') ? 'selected ' : '' ?>value="15">15 минут</option>
                <option <?=(@$data->prep_time === '20') ? 'selected ' : '' ?>value="20">20 минут</option>
                <option <?=(@$data->prep_time === '25') ? 'selected ' : '' ?>value="25">25 минут</option>
                <option <?=(@$data->prep_time === '30') ? 'selected ' : '' ?>value="30">30 минут</option>
                <option <?=(@$data->prep_time === '35') ? 'selected ' : '' ?>value="35">35 минут</option>
                <option <?=(@$data->prep_time === '40') ? 'selected ' : '' ?>value="40">40 минут</option>
                <option <?=(@$data->prep_time === '45') ? 'selected ' : '' ?>value="45">45 минут</option>
                <option <?=(@$data->prep_time === '50') ? 'selected ' : '' ?>value="50">50 минут</option>
                <option <?=(@$data->prep_time === '55') ? 'selected ' : '' ?>value="55">55 минут</option>
                <option <?=(@$data->prep_time === '60') ? 'selected ' : '' ?>value="60">1 час</option>
                <option <?=(@$data->prep_time === '65') ? 'selected ' : '' ?>value="65">1 час 5 минут</option>
                <option <?=(@$data->prep_time === '70') ? 'selected ' : '' ?>value="70">1 час 10 минут</option>
                <option <?=(@$data->prep_time === '75') ? 'selected ' : '' ?>value="75">1 час 15 минут</option>
                <option <?=(@$data->prep_time === '80') ? 'selected ' : '' ?>value="80">1 час 20 минут</option>
                <option <?=(@$data->prep_time === '85') ? 'selected ' : '' ?>value="85">1 час 25 минут</option>
                <option <?=(@$data->prep_time === '90') ? 'selected ' : '' ?>value="90">1 час 30 минут</option>
                <option <?=(@$data->prep_time === '95') ? 'selected ' : '' ?>value="95">1 час 35 минут</option>
                <option <?=(@$data->prep_time === '100') ? 'selected ' : '' ?>value="100">1 час 40 минут</option>
                <option <?=(@$data->prep_time === '105') ? 'selected ' : '' ?>value="105">1 час 45 минут</option>
                <option <?=(@$data->prep_time === '110') ? 'selected ' : '' ?>value="110">1 час 50 минут</option>
                <option <?=(@$data->prep_time === '115') ? 'selected ' : '' ?>value="115">1 час 55 минут</option>
                <option <?=(@$data->prep_time === '120') ? 'selected ' : '' ?>value="120">2 часа</option>
            </select></div>
        <div class="col-md-4">
            <label for="input-cook-time">
                Сколько готовить
            </label>
            <select name="cook_time" id="input-cook-time" class="form-control">
                <option <?=(@$data->cook_time === '5') ? 'selected ' : '' ?>value="5">5 минут</option>
                <option <?=(@$data->cook_time === '10') ? 'selected ' : '' ?>value="10">10 минут</option>
                <option <?=(@$data->cook_time === '15') ? 'selected ' : '' ?>value="15">15 минут</option>
                <option <?=(@$data->cook_time === '20') ? 'selected ' : '' ?>value="20">20 минут</option>
                <option <?=(@$data->cook_time === '25') ? 'selected ' : '' ?>value="25">25 минут</option>
                <option <?=(@$data->cook_time === '30') ? 'selected ' : '' ?>value="30">30 минут</option>
                <option <?=(@$data->cook_time === '35') ? 'selected ' : '' ?>value="35">35 минут</option>
                <option <?=(@$data->cook_time === '40') ? 'selected ' : '' ?>value="40">40 минут</option>
                <option <?=(@$data->cook_time === '45') ? 'selected ' : '' ?>value="45">45 минут</option>
                <option <?=(@$data->cook_time === '50') ? 'selected ' : '' ?>value="50">50 минут</option>
                <option <?=(@$data->cook_time === '55') ? 'selected ' : '' ?>value="55">55 минут</option>
                <option <?=(@$data->cook_time === '60') ? 'selected ' : '' ?>value="60">1 час</option>
                <option <?=(@$data->cook_time === '65') ? 'selected ' : '' ?>value="65">1 час 5 минут</option>
                <option <?=(@$data->cook_time === '70') ? 'selected ' : '' ?>value="70">1 час 10 минут</option>
                <option <?=(@$data->cook_time === '75') ? 'selected ' : '' ?>value="75">1 час 15 минут</option>
                <option <?=(@$data->cook_time === '80') ? 'selected ' : '' ?>value="80">1 час 20 минут</option>
                <option <?=(@$data->cook_time === '85') ? 'selected ' : '' ?>value="85">1 час 25 минут</option>
                <option <?=(@$data->cook_time === '90') ? 'selected ' : '' ?>value="90">1 час 30 минут</option>
                <option <?=(@$data->cook_time === '95') ? 'selected ' : '' ?>value="95">1 час 35 минут</option>
                <option <?=(@$data->cook_time === '100') ? 'selected ' : '' ?>value="100">1 час 40 минут</option>
                <option <?=(@$data->cook_time === '105') ? 'selected ' : '' ?>value="105">1 час 45 минут</option>
                <option <?=(@$data->cook_time === '110') ? 'selected ' : '' ?>value="110">1 час 50 минут</option>
                <option <?=(@$data->cook_time === '115') ? 'selected ' : '' ?>value="115">1 час 55 минут</option>
                <option <?=(@$data->cook_time === '120') ? 'selected ' : '' ?>value="120">2 часа</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="input-cook-yield">
                Количество порций
            </label>
            <input type="text" class="form-control" id="input-cook-yield" name="cook_yield" value="<?=@$data->cook_yield ?: (mt_rand(0,1)+1)*2 ?>"/>
        </div>
    </div>
</div>
<div class="form-group microdata-input">
    <label for="input-ingredients">
        Тебе понадобится
    </label>
    <textarea class="form-control" id="input-ingredients" name="ingredients"><?=!empty($data->ingredients) ? implode("\r", $data->ingredients) : ''?></textarea>
</div>
<div class="form-group microdata-input">
    <label for="input-instructions">
        Приготовление
    </label>
    <textarea class="form-control" id="input-instructions" name="instructions"><?=!empty($data->instructions) ? implode("\r", $data->instructions) : ''?></textarea>
</div>
<div class="form-group microdata-input">
    <label for="input-step-photos">
        Пошаговые фото
    </label>
    <textarea class="form-control" id="input-step-photos" name="step_photos"><?php echo $step_photos ?></textarea>
</div>
<input type="hidden" name="rating_value" value="<?=@$data->rating_value ?: mt_rand(47, 50) / 10 ?>">
<input type="hidden" name="rating_count" value="<?=@$data->rating_count ?: mt_rand(51,150) ?>">