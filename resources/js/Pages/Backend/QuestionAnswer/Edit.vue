<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "faq",
        icon: "view-list",
        bc: [{label: "faq", route: "admin.faq.questions-answers.index"}, {label: "edit"}]
    }, () => page)
};
</script>
<script setup>
import {__} from "@core/Mixins/translations";
import {useForm} from "@inertiajs/vue3";
import SaveFormButton from "@core/Components/Form/SaveFormButton.vue";
import Input from "@core/Components/Form/Input.vue";
import {ref} from "vue";
import Select from "@core/Components/Select.vue";
import ToggleButton from "@core/Components/Form/ToggleButton.vue";
import Ckeditor from "@core/Components/Form/Ckeditor.vue";
import {useStore} from "vuex";

const props = defineProps(["questionAnswer", "categories", "errors"]);

const selectedLocale = ref();
const store = useStore();
const form = useForm({
    ...props.questionAnswer
});


function submit() {
    form.put(route("admin.faq.questions-answers.update", {questionAnswer: props.questionAnswer.id}), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => store.dispatch("backend/addAlert", {type: "success", message: __("saved")}),
        onError: () => store.dispatch("backend/addAlert", {type: "error", message: props.errors})
    });
}
</script>

<template>
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden mt-4">
        <span class="dark:text-light font-medium text-xl">{{ __("edit_title") }}</span>
    </div>
    <form class="pb-8"
          @submit.prevent="submit">
        <div class="text-skin-base
                    border
                    dark:border-gray-600
                    bg-white dark:bg-gray-600
                    rounded-lg
                    shadow">
            <div class="grid grid-cols-12 divide-y xl:divide-x divide-gray-300 dark:divide-gray-700">
                <!-- title, summary and body-->
                <div class="p-6 col-span-full xl:col-span-8">
                    <div class="mb-6">
                        <Input v-model="form"
                               v-model:locale="selectedLocale"
                               :errors="form.errors"
                               :label="__('question')"
                               autofocus
                               name="question"
                               required
                               translation/>
                    </div>
                    <div class="mb-6">
                        <div class="mt-1"
                             style="--ck-border-radius: 0.50rem">
                            <Ckeditor v-model="form"
                                      v-model:locale="selectedLocale"
                                      :errors="form.errors"
                                      :label="__('answer')"
                                      name="answer"
                                      required
                                      translation></Ckeditor>
                        </div>
                    </div>
                </div>
                <!-- draf, date, category and cover -->
                <div class="col-span-full xl:col-span-4 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-1 divide-y lg:divide-x lg:divide-y-0 xl:divide-y xl:divide-x-0 divide-gray-300 dark:divide-gray-700 gap-4">
                    <!-- draft, date and category -->
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="text-sm">{{ __("draft") }}</label>
                            <ToggleButton v-model="form.draft"/>
                        </div>
                        <div>
                            <Select v-model="form.category_id"
                                    :errors="errors"
                                    :label="__('select_category')"
                                    :options="categories"
                                    name="category_id"
                                    option-label="name"
                                    reduce
                                    required></Select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- seo -->
            <div class="rounded-b-lg overflow-hidden">
                <div class="p-3 bg-gray-200 dark:bg-gray-500 flex justify-end">
                    <SaveFormButton :form="form"/>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
