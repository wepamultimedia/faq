<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps({
    number: {
        type: Number,
        default: 10
    }
});

const show = ref(null);
const questions = ref([]);
const currentQuestionAnswer = ref({id: null, answer: null});

function loadQuestions() {
    axios.get(route('api.v1.faq.questions-answers.questions', {number: props.number}))
        .then(response => {
            questions.value = response.data.data;
        });
}

function loadAnswer(questionAnswer) {
    if (questionAnswer.id !== currentQuestionAnswer.value.id) {
        axios.get(route('api.v1.faq.questions-answers.answer', {questionAnswer: questionAnswer.id}))
            .then(response => {
                currentQuestionAnswer.value = response.data.data;
            });
    } else {
        questionAnswer.value = null;
    }
}

onMounted(() => {
    loadQuestions();
});

</script>

<template>
    <ul class="[&>li]:my-2">
        <template v-for="question in questions"
                  :key="'faq-' + question.id">
            <li :class="{'border-gray-600 border-2' : question.id === currentQuestionAnswer.id}"
                class="px-4 overflow-hidden py-2 border border-gray-600">
                <button class="font-semibold w-full text-left flex justify-between items-center"
                        @click="loadAnswer(question)">
                    <span :class="{'' : question.id === currentQuestionAnswer.id}" class="text-xl">{{ question.question }}</span>
                    <svg :class="{'rotate-0' : question.id === currentQuestionAnswer.id}"
                         aria-hidden="true"
                         class="w-6 h-6 -rotate-90"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5"
                         viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </svg>
                </button>
                <transition name="faq-answer">
                    <p v-if="currentQuestionAnswer.id === question.id"
                       class="m-0 p-0 my-4 pl-4 ml-4 border-l border-gray-600 ckeditor"
                       v-html="currentQuestionAnswer.answer">
                    </p>
                </transition>
            </li>
        </template>
    </ul>
</template>

<style scoped>
.faq-answer-enter-from, .faq-answer-leave-to {
    @apply translate-x-full
}

.faq-answer-enter-to, .faq-answer-leave-from {
    @apply translate-x-0
}

.faq-answer-enter-active, .faq-answer-leave-active {
    @apply transition-all ease-in-out duration-200
}
</style>
