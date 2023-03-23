require('./bootstrap');

import Vue from 'vue';

Vue.component('course-create', require('./components/course/create').default);
Vue.component('course-edit', require('./components/course/edit').default);
Vue.component('course-index', require('./components/course/index').default);
Vue.component('course-view', require('./components/course/view').default);

Vue.component('book-create', require('./components/book/create').default);
Vue.component('book-index', require('./components/book/index').default);
Vue.component('book-edit', require('./components/book/edit').default);
Vue.component('book-view', require('./components/book/view').default);

Vue.component('student-index', require('./components/student/index').default);
Vue.component('student-create', require('./components/student/create').default);
Vue.component('student-edit', require('./components/student/edit').default);
Vue.component('student-view', require('./components/student/view').default);
Vue.component('student-report', require('./components/student/report').default);
Vue.component('student-course-detail', require('./components/student/courseDetail').default);
Vue.component('student-gift-reminder', require('./components/student/giftReminder').default);
Vue.component('student-export', require('./components/student/export').default);

Vue.component('user-index', require('./components/user/index').default);
Vue.component('user-create', require('./components/user/create').default);
Vue.component('user-edit', require('./components/user/edit').default);
Vue.component('user-view', require('./components/user/view').default);
Vue.component('user-edit-profile', require('./components/user/editProfile').default);

Vue.component('test-index', require('./components/test/index').default);
Vue.component('test-create', require('./components/test/create').default);
Vue.component('test-edit', require('./components/test/edit').default);
Vue.component('test-view', require('./components/test/view').default);
Vue.component('offline-test-entry', require('./components/test/offlineTestEntry').default);

Vue.component('lesson-create', require('./components/lesson/create').default);
Vue.component('lesson-index', require('./components/lesson/index').default);
Vue.component('lesson-edit', require('./components/lesson/edit').default);
Vue.component('lesson-view', require('./components/lesson/view').default);

Vue.component('test-result-index', require('./components/testResult/index').default);
Vue.component('test-result-edit', require('./components/testResult/edit').default);

import Vue2Editor from "vue2-editor";

Vue.use(Vue2Editor);
const app = new Vue({
    el: '#wrapper',
});
