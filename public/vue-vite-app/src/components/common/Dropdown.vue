<template lang="">
    <div v-if="isLabel">
        <span
        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[21px] tdprb-text-left tdprb-text-themeColor">Select Ring Size:
        {{ selectedOption }}</span>
    </div>
    <div ref="tdprbCommonDropdown"  @click="toggle" class="tdprb-relative tdprb-h-[50px] tdprb-w-[200px] tdprb-flex tdprb-justify-between tdprb-items-center tdprb-border tdprb-border-borderColor tdprb-rounded tdprb-px-[15px] tdprb-cursor-pointer">
        <span class="tdprb-font-poppins tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[24px] tdprb-text-textPrimaryColor">{{ selected || defaultText}}</span>
        <span>
            <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 6L5.24537e-07 -1.04907e-06L12 0L6 6Z" fill="#969696"/>
            </svg>   
        </span>

        <!-- options -->
         <div v-if="toggleDropdown" class="tdprb-absolute tdprb-top-[50px] tdprb-left-0 tdprb-w-full tdprb-h-auto tdprb-bg-backgroundColor tdprb-border tdprb-border-borderColor tdprb-rounded tdprb-p-2 tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-center tdprb-gap-2 tdprb-max-h-[250px] tdprb-overflow-y-auto" >
            <template v-for="(option, index) in options" :key="index">
                <label @click="dropdownHandle(option)" class="tdprb-flex tdprb-justify-start tdprb-items-center tdprb-text-start  tdprb-cursor-pointer  tdprb-border-b tdprb-border-b-borderColor  tdprb-w-full tdprb-min-h-[40px] tdprb-pl-2 " :class="selected == option ? 'tdprb-shadow tdprb-rounded tdprb-border tdprb-border-borderColor tdprb-bg-themeColor tdprb-text-backgroundColor' : 'hover:tdprb-shadow hover:tdprb-rounded tdprb-bg-backgroundColor tdprb-text-textSecondaryColor'">
                    {{option}}
                </label>
            </template>
</div>
</div>
</template>
<script>
export default {
    props: {
        options: {
            type: Array,
            default: []
        },
        selectedOption: {
            type: String,
            default: null
        },
        defaultText: {
            type: String,
            default: 'Dropdown'
        },
        isLabel: {
            type: Boolean,
            default: false
        }
    },
    emits: ['setDropDownValue'],
    data() {
        return {
            toggleDropdown: false,
            selected: null,
        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
        this.selected = this.selectedOption
    },
    methods: {
        handleClickOutside(event) {
            if (this.$refs.tdprbCommonDropdown && !this.$refs.tdprbCommonDropdown.contains(event.target)) {
                this.toggleDropdown = false;
            }
        },
        toggle() {
            this.toggleDropdown = !this.toggleDropdown;
        },
        dropdownHandle(value) {
            this.selected = value
        }
    },
    watch: {
        selected(newVal) {
            this.$emit('setDropDownValue', newVal)
        }
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
}
</script>
<style lang="">

</style>

<!-- use case
import DropDown from '../../components/common/Dropdown.vue';

export default {
    components:{
        DropDown
    },
    data() {
        return {
            options : ['option-1','option-2','option-3'],
            selectedOption : null,
        }
    },
    methods: {
        setDropDownValue(value){
             this.selectedOption = value;
        },
    }
} -->