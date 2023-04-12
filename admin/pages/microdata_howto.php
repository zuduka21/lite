<div class="form-group microdata-input">
    <label for="input-description">
        Описание
    </label>
    <textarea class="form-control" id="input-description" name="description"><?=($data->description ?: '')?></textarea>
</div>
<div class="form-group microdata-input">
    <div class="row">
        <div class="col-md-6">
            <label for="input-total-time">
                Время выполнения
            </label>
            <select name="total_time" id="input-total-time" class="form-control">
                <option <?=(@$data->total_time === '5') ? 'selected ' : '' ?>value="5">5 минут</option>
                <option <?=(@$data->total_time === '10') ? 'selected ' : '' ?>value="10">10 минут</option>
                <option <?=(@$data->total_time === '15') ? 'selected ' : '' ?>value="15">15 минут</option>
                <option <?=(@$data->total_time === '20') ? 'selected ' : '' ?>value="20">20 минут</option>
                <option <?=(@$data->total_time === '25') ? 'selected ' : '' ?>value="25">25 минут</option>
                <option <?=(@$data->total_time === '30') ? 'selected ' : '' ?>value="30">30 минут</option>
                <option <?=(@$data->total_time === '35') ? 'selected ' : '' ?>value="35">35 минут</option>
                <option <?=(@$data->total_time === '40') ? 'selected ' : '' ?>value="40">40 минут</option>
                <option <?=(@$data->total_time === '45') ? 'selected ' : '' ?>value="45">45 минут</option>
                <option <?=(@$data->total_time === '50') ? 'selected ' : '' ?>value="50">50 минут</option>
                <option <?=(@$data->total_time === '55') ? 'selected ' : '' ?>value="55">55 минут</option>
                <option <?=(@$data->total_time === '60') ? 'selected ' : '' ?>value="60">1 час</option>
                <option <?=(@$data->total_time === '65') ? 'selected ' : '' ?>value="65">1 час 5 минут</option>
                <option <?=(@$data->total_time === '70') ? 'selected ' : '' ?>value="70">1 час 10 минут</option>
                <option <?=(@$data->total_time === '75') ? 'selected ' : '' ?>value="75">1 час 15 минут</option>
                <option <?=(@$data->total_time === '80') ? 'selected ' : '' ?>value="80">1 час 20 минут</option>
                <option <?=(@$data->total_time === '85') ? 'selected ' : '' ?>value="85">1 час 25 минут</option>
                <option <?=(@$data->total_time === '90') ? 'selected ' : '' ?>value="90">1 час 30 минут</option>
                <option <?=(@$data->total_time === '95') ? 'selected ' : '' ?>value="95">1 час 35 минут</option>
                <option <?=(@$data->total_time === '100') ? 'selected ' : '' ?>value="100">1 час 40 минут</option>
                <option <?=(@$data->total_time === '105') ? 'selected ' : '' ?>value="105">1 час 45 минут</option>
                <option <?=(@$data->total_time === '110') ? 'selected ' : '' ?>value="110">1 час 50 минут</option>
                <option <?=(@$data->total_time === '115') ? 'selected ' : '' ?>value="115">1 час 55 минут</option>
                <option <?=(@$data->total_time === '120') ? 'selected ' : '' ?>value="120">2 часа</option>
            </select></div>
    </div>
</div>
<div class="form-group microdata-input">
    <label for="input-supplies">
        Материалы
    </label>
    <textarea class="form-control" id="input-supplies" name="supplies"><?= !empty($data->supplies) ? implode("\r", $data->supplies) : ''?></textarea>
</div>
<div class="form-group microdata-input">
    <label for="input-tools">
        Инструменты
    </label>
    <textarea class="form-control" id="input-tools" name="tools"><?= !empty($data->tools) ? implode("\r", $data->tools) : ''?></textarea>
</div>
<div class="form-group microdata-input">
    <label for="input-steps">
        Как сделать
    </label>
    <textarea class="form-control" id="input-steps" name="steps"><?= !empty($data->steps) ? implode("\r", $data->steps) : ''?></textarea>
</div>
