<template lang="">
    <div v-if="tabs.length" class="tdprb-w-full tdprb-h-auto tdprb-px-[15px] md:tdprb-px-[30px] tdprb-flex">
        <div
            class="tdprb-h-auto md:tdprb-w-auto tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-[10px] tdprb-m-auto tdprb-my-[25px] md:tdprb-my-[50px]  tdprb-bg-backgroundColor tdprb-text-textSecondaryColor tdprb-p-[3px] tdprb-rounded-md tdprb-border tdprb-border-borderColor">
            <label @click="updateDiamondType('natural')" v-if="getDefaultDiamondTypeToDisplay == 'Both' || getDefaultDiamondTypeToDisplay == 'both' || getDefaultDiamondTypeToDisplay == 'natural'" for="diamondType-natural" 
                class="tdprb-select-none tdprb-h-[40px] tdprb-w-full md:tdprb-h-[50px] md:tdprb-w-[250px] tdprb-cursor-pointer tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-[5px] md:tdprb-gap-[10px]  tdprb-border-none tdprb-rounded-md"
                :class="diamondType == 'labgrown' ? 'tdprb-bg-backgroundColor tdprb-text-themeColor' : 'tdprb-bg-themeColor tdprb-text-backgroundColor'">
                <input type="radio" value="natural" v-model="diamondType" name="diamondType" id="diamondType-natural" class="tdprb-hidden"  hidden />
                <span class="tdprb-flex tdprb-items-center tdprb-justify-center">
                    <svg class="tdprb-h-[16px] tdprb-w-[16px] md:tdprb-h-[20px] md:tdprb-w-[20px]" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_275_6)">
                            <path
                                d="M19.9013 7.32354L16.6333 2.07303C16.514 1.88132 16.3042 1.76476 16.0784 1.76476H3.92167C3.69597 1.76476 3.48617 1.88132 3.36675 2.07303L0.0988094 7.32354C-0.0580643 7.57561 -0.0256037 7.90154 0.178106 8.11744L9.52444 18.03C9.64795 18.1609 9.82006 18.2352 10 18.2352C10.18 18.2352 10.3521 18.1609 10.4756 18.0298L19.8219 8.11744C20.0255 7.90131 20.0581 7.57561 19.9013 7.32354ZM10.0001 16.6289L1.47462 7.58694L4.28483 3.07193H15.7154L18.5255 7.58694L10.0001 16.6289Z"
                                :fill="diamondType == 'labgrown' ? prussianBlue() : white()" />
                            <path d="M19.3465 7.01526H0.653809V8.32244H19.3465V7.01526Z"
                                :fill="diamondType == 'labgrown' ? prussianBlue() : white()" />
                            <path
                                d="M6.71391 7.60634L7.72175 2.54603L6.43961 2.29068L5.39388 7.54118C5.36927 7.66536 5.38103 7.79392 5.4281 7.91157L9.39322 17.8243L10.6069 17.339L6.71391 7.60634Z"
                                :fill="diamondType == 'labgrown' ? prussianBlue() : white()" />
                            <path
                                d="M14.648 7.48869L13.5587 2.39069L12.2805 2.66389L13.3282 7.56647L9.39404 17.3376L10.6065 17.8256L14.6154 7.86951C14.6637 7.74861 14.6753 7.61592 14.648 7.48869Z"
                                :fill="diamondType == 'labgrown' ? prussianBlue() : white()" />
                        </g>
                        <defs>
                            <clipPath id="clip0_275_6">
                                <rect width="20" height="20" :fill="white()" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <span class="tdprb-text-[12px] tdprb-font-[600] tdprb-leading-[14px] md:tdprb-text-[16px] md:tdprb-font-[600] md:tdprb-leading-[18px] md:tdprb-h-[20px]  ">{{tabs[0] || 'Natural Diamonds'}}</span>
            </label>
            <label @click="updateDiamondType('labgrown')" v-if="getDefaultDiamondTypeToDisplay == 'Both' || getDefaultDiamondTypeToDisplay == 'both' || getDefaultDiamondTypeToDisplay == 'lab-grown'" for="diamondType-labgrown"
                class="tdprb-select-none tdprb-h-[40px] tdprb-w-full md:tdprb-h-[50px] md:tdprb-w-[250px] tdprb-cursor-pointer  tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-[5px] md:tdprb-gap-[10px]  tdprb-border-none tdprb-rounded-md"
                :class="diamondType == 'natural' ?  'tdprb-bg-backgroundColor tdprb-text-themeColor' : 'tdprb-bg-themeColor tdprb-text-backgroundColor'">
                <input type="radio" value="labgrown" v-model="diamondType" name="diamondType" id="diamondType-labgrown" class="tdprb-hidden"  hidden />
                <span class="tdprb-flex tdprb-items-center tdprb-justify-center">
                    <svg class="tdprb-h-[16px] tdprb-w-[16px] md:tdprb-h-[20px] md:tdprb-w-[20px]" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_275_6)">
                            <path
                                d="M19.9013 7.32354L16.6333 2.07303C16.514 1.88132 16.3042 1.76476 16.0784 1.76476H3.92167C3.69597 1.76476 3.48617 1.88132 3.36675 2.07303L0.0988094 7.32354C-0.0580643 7.57561 -0.0256037 7.90154 0.178106 8.11744L9.52444 18.03C9.64795 18.1609 9.82006 18.2352 10 18.2352C10.18 18.2352 10.3521 18.1609 10.4756 18.0298L19.8219 8.11744C20.0255 7.90131 20.0581 7.57561 19.9013 7.32354ZM10.0001 16.6289L1.47462 7.58694L4.28483 3.07193H15.7154L18.5255 7.58694L10.0001 16.6289Z"
                                :fill="diamondType == 'natural' ? prussianBlue() : white()" />
                            <path d="M19.3465 7.01526H0.653809V8.32244H19.3465V7.01526Z"
                                :fill="diamondType == 'natural' ? prussianBlue() : white()" />
                            <path
                                d="M6.71391 7.60634L7.72175 2.54603L6.43961 2.29068L5.39388 7.54118C5.36927 7.66536 5.38103 7.79392 5.4281 7.91157L9.39322 17.8243L10.6069 17.339L6.71391 7.60634Z"
                                :fill="diamondType == 'natural' ? prussianBlue() : white()" />
                            <path
                                d="M14.648 7.48869L13.5587 2.39069L12.2805 2.66389L13.3282 7.56647L9.39404 17.3376L10.6065 17.8256L14.6154 7.86951C14.6637 7.74861 14.6753 7.61592 14.648 7.48869Z"
                                :fill="diamondType == 'natural' ? prussianBlue() : white()" />
                        </g>
                        <defs>
                            <clipPath id="clip0_275_6">
                                <rect width="20" height="20" :fill="white()" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <span class="tdprb-text-[12px] tdprb-font-[600] tdprb-leading-[14px] md:tdprb-text-[16px] md:tdprb-font-[600] md:tdprb-leading-[18px] md:tdprb-h-[20px]  tdprb-text-center">{{tabs[1] ||  'Lab Grown Diamonds'}}</span>
            </label>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            tabs: [],
            diamondType: null // natural or labgrown
        }
    },
    methods: {
        prussianBlue() {
            return this.$colors().prussianBlue;
        },
        gray() {
            return this.$colors().gray;
        },
        white() {
            return this.$colors().white;
        },
        updateDiamondType(value) {
            this.$store.dispatch('diamondFilters/updateFilterValue', { filter: 'diamond_type', value: value });
        },
        updateQueryString(name, value) {
            if (name && value) {
                const query = { ...this.$route.query, [name]: value.toLowerCase() };
                this.$router.push({ query });
            }
        },
    },
    computed: {
        tabsTexts() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('tabs_texts');
        },
        getDiamondTypeValue() {
            // Retrieve filter data from the store
            return this.$store.getters['diamondFilters/getFilterValue']('diamond_type');
        },
        getDefaultDiamondTypeToDisplay() {
            // Retrieve filter data from the store
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('default_type');
        },
    },
    mounted() {
        this.diamondType = this.getDiamondTypeValue
        this.updateQueryString('type', this.diamondType)
    },
    watch: {
        diamondType: {
            handler(newType) {
                if (!!newType) {
                    this.updateQueryString('type', newType);
                }
            },
        },
        tabsTexts: {
            handler(newValue) {
                if (!!newValue) {
                    this.tabs = Object.values(newValue);
                }
            },
            immediate: true
        }
    }

}
</script>
<style lang="">

</style>