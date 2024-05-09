export default {
    beforeMount(el, binding, vnode, prevVnode) {
        el.clickOutsideEvent = (event) => {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    beforeUnmount(el, binding, vnode, prevVnode) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    },
};
