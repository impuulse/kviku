<?php

/* @var $this yii\web\View */

$this->title = 'Регистрация';
$js = <<<JS
    const apiUrl = '/user/sign-up';
    new Vue({
      el: '#app',
      data: {
        errors: [],
        last_name: '',
        first_name: '',
        middle_name: '',
        birthday: '',
        passport: '',
        email: '',
        phone: ''
      },
      methods: {
        checkForm: function (e) {
          e.preventDefault();
    
          fetch(apiUrl, {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({
                "last_name": this.last_name,
                "first_name": this.first_name,
                "middle_name": this.middle_name,
                "birthday": this.birthday,
                "passport": this.passport,
                "email": this.email,
                "phone": this.phone
            })
          })
          .then(res => res.json())
          .then(res => {
            if (res.success) {
                alert('Заявка успешно подана!');
            } else {
                this.errors = [];
                let errorObject = res.data.errorInfo;
                for(let index in errorObject) { 
                    const fieldErrors = errorObject[index]; 
                    for(let f_index in fieldErrors) {
                        this.errors.push(fieldErrors[f_index]);
                    }
                }
            }
          });
        }
      }
    })
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
<div class="site-index">
    <h3>Подача заявки</h3>
    <form
        id="application-form"
        @submit="checkForm"
        method="post"
    >
        <div class="alert alert-danger" role="alert" v-if="errors.length">
            <b>Пожалуйста исправьте указанные ошибки:</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>
        <div class="form-group">
            <label class="control-label" for="last_name">Фамилия</label>
            <input type="text" class="form-control" id="last_name" name="last_name" v-model="last_name">
            <span class="help-block"><b>Примечание:</b> Только русские символы</span>
        </div>
        <div class="form-group">
            <label class="control-label" for="first_name">Имя</label>
            <input type="text" class="form-control" id="first_name" name="first_name" v-model="first_name">
            <span class="help-block"><b>Примечание:</b> Только русские символы</span>
        </div>
        <div class="form-group">
            <label class="control-label" for="middle_name">Отчество</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" v-model="middle_name">
            <span class="help-block"><b>Примечание:</b> Только русские символы</span>
        </div>
        <div class="form-group">
            <label class="control-label" for="birthday">Дата рождения</label>
            <input type="text" class="form-control" id="birthday" name="birthday" v-model="birthday">
            <span class="help-block"><b>Примечание:</b> в формате - 22.09.1987</span>
        </div>
        <div class="form-group">
            <label class="control-label" for="passport">Серия и номер паспорта</label>
            <input type="text" class="form-control" id="passport" name="passport" v-model="passport">
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" v-model="email">
        </div>
        <div class="form-group">
            <label class="control-label" for="phone">Номер телефона</label>
            <input type="text" class="form-control" id="phone" name="phone" v-model="phone">
            <span class="help-block"><b>Примечание:</b> в формате +79267270848</span>
        </div>
        <p>
            <input type="submit" value="Отправить" class="btn btn-success">
        </p>
    </form>
</div>
