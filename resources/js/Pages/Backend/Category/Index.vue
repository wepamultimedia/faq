<script>
import MainLayout from "@pages/Vendor/Core/Backend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, {
        title: "Categories",
        icon: "view-list",
        bc: [{label: "faq"},{label: "categories"}]
    }, () => page)
};
</script>
<script setup>
import {Link, router} from "@inertiajs/vue3";
import Table from "@core/Components/Table.vue";
import Icon from "@core/Components/Heroicon.vue";

const props = defineProps(["categories"]);

const updatePosition = (item, position) => {
    router.put(route("admin.faq.categories.position", {
        category: item.id,
        position: position
    }), {},{
        preserveState: true,
        preserveScroll: true
    });
}
</script>

<template>
    <div class="flex justify-between my-0 items-center h-14 rounded-lg overflow-hidden my-6">
        <span class="text-skin-base  font-medium text-xl">{{ __("categories_list") }}</span>
        <Link :href="route('admin.faq.categories.create')"
              as="button"
              class="btn btn-success text-sm"
              type="button">{{ __("create") }}
        </Link>
    </div>
    <div class="w-full
                    bg-white dark:bg-gray-700
                    overflow-hidden
                    shadow
                    text-skin-base
                    rounded-lg
                    mb-20">
        <Table :columns="['name', 'position']"
               :data="categories"
               delete-route="admin.faq.categories.destroy"
               divide-x
               edit-route="admin.faq.categories.edit"
               even
               search-route="admin.faq.categories.index">
            <template #col-content-position="{item}">
                <div class="flex items-center justify-start">
                    <div class="inline-flex"
                         role="group">
                        <button class="rounded-l-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                type="button"
                                @click="updatePosition(item, item.position - 1)">
                            <Icon class="m-0 fill-white h-4 w-4"
                                  icon="chevron-up"></Icon>
                        </button>
                        <span class="px-2 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase"
                              type="button">
                            {{ item.position }}
                        </span>
                        <button class="rounded-r-lg px-1 py-2.5 bg-gray-400 text-white font-medium text-xs leading-tight uppercase hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-0 active:bg-gray-800 transition duration-150 ease-in-out"
                                type="button"
                                @click="updatePosition(item, item.position + 1)">
                            <Icon class="m-0 fill-white h-4 w-4"
                                  icon="chevron-down"></Icon>
                        </button>
                    </div>
                </div>
            </template>
        </Table>
    </div>
</template>

<style scoped>

</style>
