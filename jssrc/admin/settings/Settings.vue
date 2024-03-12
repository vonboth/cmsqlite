<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    inject: ['translations'],

    data() {
        return {
            addNewSetting: false,
            editSettingId: null,
            prevSettingsValue: ''
        };
    },

    props: {
        settings: {
            type: Array,
            required: true
        },
        csrfToken: {
            type: String,
            required: true
        }
    },

    methods: {
        onSaveSetting(id, name) {
            let formData = new FormData(),
                el = document.getElementById('id-' + name);

            formData.append('value', el.value);
            axios.post(
                `/admin/settings/save/${id}`,
                formData, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                })
                .then((response) => {
                    window.location.reload();
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        onEditSetting(id, name) {
            console.log(id, name);
            const el = document.getElementById('id-' + name);
            this.prevSettingsValue = el.value;
            this.editSettingId = id;
            el.removeAttribute('disabled');
        },

        onDeleteSetting(id) {
            Swal.fire({
                icon: 'warning',
                title: translations.delete_setting,
                text: translations.delete_question,
                showCancelButton: true,
                cancelButtonText: translations.no,
                confirmButtonText: translations.yes
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(
                        `/admin/settings/delete/${id}`,
                        {},
                        {
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken
                            }
                        })
                        .then((response) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            });
        },

        onCancelEditSetting(name) {
            let el = document.getElementById('id-' + name);
            el.value = this.prevSettingsValue;
            this.prevSettingsValue = '';
            this.editSettingId = null;
            el.setAttribute('disabled', true);
        },

        onCancelNewSetting() {
            this.addNewSetting = false;
            document.getElementById('new_name').value = '';
            document.getElementById('new_value').value = '';
        }
    }
};
</script>

<template>
    <div class="row">
        <div class="col s12">
            <a @click="() => { addNewSetting = true; console.log(addNewSetting) }"
               class="btn-floating waves-effect waves-light blue pointer">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div>
                <div class="row" v-for="setting in settings">
                    <div class="input-field col s6">
                        <input type="text"
                               :id="`id-${setting.name}`"
                               @keyup.enter="onSaveSetting(setting.id, setting.name)"
                               class="settings-input"
                               disabled
                               v-bind:disabled="editSettingId !== setting.id"
                               :name="setting.name"
                               :value="setting.value"/>
                        <label :for="`id-${setting.name}`">{{ translations.settings[setting.name] || setting.name }}</label>
                    </div>
                    <div class="col s2 input-field pt1">
                        <div class="inline-block"
                             :class="{hide: editSettingId === setting.id}">
                            <a class="pointer"
                               :title="translations.edit"
                               @click="onEditSetting(setting.id, setting.name)">
                                <i class="material-icons">edit</i></a>
                            <a class="pointer"
                               :title="translations.delete_item"
                               @click="onDeleteSetting(setting.id)">
                                <i class="material-icons">delete</i></a>
                        </div>
                        <div class="inline-block"
                             :class="{hide: editSettingId !== setting.id}">
                            <a class="pointer"
                               :title="translations.cancel"
                               @click="onCancelEditSetting(setting.name)">
                                <i class="material-icons">cancel</i></a>
                            <a class="pointer"
                               :title="translations.save"
                               @click="onSaveSetting(setting.id, setting.name)">
                                <i class="material-icons">save</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="/admin/settings/add">
                <input type="hidden" name="cmsql_csrf_token" :value="csrfToken"/>
                <div :class="{ 'hide': !addNewSetting }">
                    <div class="row">
                        <div class="input-field col s5">
                            <input type="text" name="name" id="new_name"/>
                            <label for="new_name">{{ translations.settings.name }}</label>
                        </div>
                        <div class="input-field col s5">
                            <input type="text" name="value" id="new_value"/>
                            <label for="new_value">{{ translations.settings.value }}</label>
                        </div>
                        <div class="col s2 input-field pt1">
                            <div class="inline-block">
                                <a class="pointer"
                                   @click="onCancelNewSetting">
                                    <i class="material-icons">cancel</i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <button type="submit" class="btn waves-light waves-effect">{{ translations.save }}
                                <i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
