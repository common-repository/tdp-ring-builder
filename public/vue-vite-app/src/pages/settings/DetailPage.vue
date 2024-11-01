<template>
    <Alert v-show="addToCartVar.error" :message="addToCartVar.message" />
    <Alert v-show="popup.status" :message="popup.message" type="info" />
    <Loader v-if="loading" containerClass="tdprb-h-screen" />
    <Error v-else-if="dataNotFound" :message="dataNotFoundMsg" containerClass="tdprb-h-screen" />
    <div v-else class="tdprb-w-full md:tdprb-px-[30px] tdprb-px-[15px]">

        <!-- back to search container  -->
        <div class="tdprb-w-full md:tdprb-my-10 tdprb-my-5">
            <div class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-2">
                <div class="tdprb-cursor-pointer tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-left tdprb-text-themeColor tdprb-gap-2"
                    @click="backToSearch">
                    <span class="tdprb-flex tdprb-justify-center tdprb-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" :fill="prussianBlue()"
                            class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                        </svg>
                    </span>
                    <span class="tdprb-flex tdprb-justify-center tdprb-items-center">Back</span>
                </div>
            </div>
        </div>

        <!-- detail page container  -->
        <div
            class="tdprb-w-full tdprb-h-full tdprb-flex md:tdprb-flex-row tdprb-flex-col md:tdprb-gap-[40px] tdprb-gap-[20px]">

            <!-- media container  -->
            <div class="md:tdprb-w-1/2 tdprb-w-full tdprb-h-full ">
                <div class="tdprb-w-full tdprb-min-h-10 tdprb-h-full">

                    <!-- main image  -->
                    <div
                        class="tdprb-max-h-[795px] tdprb-w-[75%] tdprb-overflow-hidden tdprb-mx-auto tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-border tdprb-border-borderColor tdprb-rounded-md">
                        <!-- Loader -->
                        <Skeleton v-if="isLoading" />
                        <DefaultImage v-else-if="isError" :type="'setting'" :value="product.sub_category" />

                        <!-- Video Section -->
                        <iframe v-if="subImageSection[activeSubSection].type == 'video'" :src="product.video"
                            v-show="!isLoading && !isError" @load="onLoad" @error="onError"
                            class="tdprb-w-full tdprb-m-auto tdprb-h-full tdprb-max-h-full tdprb-object-cover"></iframe>

                        <!-- Image Section -->
                        <template v-else>
                            <img :src="subImageSection[activeSubSection].src" :alt="title"
                                v-show="!isLoading && !isError" @load="onLoad" @error="onError"
                                class="tdprb-w-full tdprb-m-auto tdprb-h-full tdprb-max-h-full tdprb-object-cover" />
                        </template>
                    </div>


                    <!-- sub images  -->
                    <div
                        class="tdprb-w-[75%]  tdprb-h-full tdprb-mx-auto tdprb-flex tdprb-justify-center tdprb-items-center tdprb-flex-wrap tdprb-gap-4 tdprb-mt-3 md:tdprb-mt-5">
                        <template v-for="(item, index) in subImageSection" :key="index">
                            <div v-if="!!item.src"
                                class="md:tdprb-h-[110px] tdprb-h-[55px] tdprb-aspect-square tdprb-border tdprb-bg-backgroundColor tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-overflow-hidden tdprb-cursor-pointer tdprb-border-borderColor"
                                :class="activeSubSection == index ? 'tdprb-border-[3px] tdprb-shadow-md' : 'tdprb-border'"
                                @click="activeSubSection = index">
                                <svg v-if="item.type == 'video'" class="tdprb-fill-borderColor tdprb-scale-75"
                                    fill="currentColor" height="80" width="80" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 60 60" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M45.563,29.174l-22-15c-0.307-0.208-0.703-0.231-1.031-0.058C22.205,14.289,22,14.629,22,15v30
                                        c0,0.371,0.205,0.711,0.533,0.884C22.679,45.962,22.84,46,23,46c0.197,0,0.394-0.059,0.563-0.174l22-15
                                        C45.836,30.64,46,30.331,46,30S45.836,29.36,45.563,29.174z M24,43.107V16.893L43.225,30L24,43.107z" />
                                        <path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M30,58C14.561,58,2,45.439,2,30
                                        S14.561,2,30,2s28,12.561,28,28S45.439,58,30,58z" />
                                    </g>
                                </svg>
                                <template v-if="item.type == 'image'">
                                    <!-- <Skeleton v-if="imageStates[index]?.isLoading" /> -->
                                    <DefaultImage v-show="imageStates[index]?.isError" :type="'setting'"
                                        :value="product.sub_category" :zoomScale="'tdprb-scale-90'" />
                                    <img v-show="!imageStates[index]?.isError" @error="onSubImageError(index)"
                                        :src="item.src" :alt="item.type"
                                        class="tdprb-object-cover tdprb-w-full tdprb-h-full">
                                </template>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

            <!-- detail container -->
            <div class="md:tdprb-w-1/2 tdprb-w-full tdprb-h-full ">

                <!-- title container -->
                <div class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center">
                    <h1
                        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[30px] tdprb-font-[600] tdprb-leading-[36px] tdprb-text-left tdprb-text-textPrimaryColor">
                        {{ title }}</h1>
                </div>

                <!-- description container  -->
                <div v-if="product?.product_description"
                    class="tdprb-w-[90%] tdprb-mt-3 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[18px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-left tdprb-text-textSecondaryColor"
                    v-html="product?.product_description"></div>

                <!-- price container  -->
                <div
                    class="tdprb-w-full tdprb-mt-3 md:tdprb-mt-5 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-2">
                    <span
                        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[30px] tdprb-font-[600] tdprb-leading-[36px] tdprb-text-left tdprb-text-themeColor">
                        {{ roundOffPrice(product?.total_price) || '-' }}
                    </span>
                    <span
                        class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-poppins tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[24px] tdprb-text-left tdprb-text-textSecondaryColor tdprb-line-through ">{{
                            roundOffPrice(increasedPrice(product?.total_price)) || '-' }}</span>
                    <span
                        class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-poppins tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[24px] tdprb-text-left tdprb-text-textSecondaryColor">(Setting
                        Only)</span>
                </div>
                <!-- shape container  -->
                <div v-if="diamondShapes.length"
                    class="tdprb-w-full tdprb-mt-3 md:tdprb-mt-5 tdprb-flex tdprb-justify-start tdprb-items-start tdprb-flex-col tdprb-gap-2">
                    <DetailPageShape :shapes="diamondShapes" @update="changeDiamondShape"
                        :selectedShape="selectedDiamondShape" />
                </div>



                <!-- metal and select ring size container  -->
                <div
                    class="tdprb-w-full tdprb-mt-3 md:tdprb-mt-5 tdprb-flex md:tdprb-flex-row tdprb-flex-col-reverse tdprb-justify-between tdprb-items-center md:tdprb-items-start tdprb-gap-3 md:tdprb-gap-5">
                    <div
                        class="tdprb-w-full  tdprb-flex tdprb-justify-start tdprb-items-start tdprb-flex-col tdprb-gap-2 tdprb-h-full md:tdprb-w-[70%]  tdprb-overflow-hidden">
                        <DetailPageMetal @update="updateMetal" :selectedMetal="selectedMetal"
                            :metalNames="this.allMetals.keys || []" />
                    </div>
                    <div class=" md:tdprb-w-[30%] tdprb-w-full tdprb-flex tdprb-flex-col tdprb-gap-2">
                        <Dropdown :isLabel="true" :defaultText="'Select Ring Size'" @setDropDownValue="updateRingSize"
                            :selectedOption="selectedRingSize" :options="ringSizeData" />
                        <div v-show="ringSizeError"
                            class="tdprb-text-red-500 tdprb-h-5 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-w-full tdprb-p-2">
                            Please Select Ring Size</div>
                    </div>
                </div>

                <!-- buttons container  -->

                <div class="tdprb-w-full tdprb-mt-4 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[10px]">
                    <!-- :class="isSameData() ? 'tdprb-opacity-50 tdprb-cursor-not-allowed' : 'hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor'" -->
                    <!-- :disabled="isSameData()" -->
                    <button
                        class="tdprb-w-[400px] tdprb-h-[60px] tdprb-text-backgroundColor tdprb-bg-themeColor  tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor"
                        @click="!!selectedRingSize ? setSettingDataToCompleteRing() : ringSizeError = true">{{
                            settingTexts?.select_this_setting
                        }}</button>
                    <!-- <button
                        class="tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-border tdprb-border-themeColor tdprb-rounded-md">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_197_15621)">
                                <path
                                    d="M21.3281 1.875C20.1416 1.87638 18.968 2.12082 17.8797 2.59326C16.7913 3.06569 15.8113 3.75609 15 4.62187C13.8111 3.35302 12.2683 2.47086 10.5717 2.08993C8.87513 1.709 7.10323 1.84688 5.48602 2.48568C3.8688 3.12448 2.48097 4.23469 1.50269 5.67219C0.524409 7.10968 0.000856078 8.80807 0 10.5469C0 19.1812 13.9266 27.6562 14.5312 27.9891C14.6771 28.0767 14.844 28.1229 15.0141 28.1229C15.1842 28.1229 15.3511 28.0767 15.4969 27.9891C16.0734 27.6562 30 19.1812 30 10.5469C29.9975 8.24771 29.0831 6.04343 27.4573 4.41767C25.8316 2.79192 23.6273 1.87748 21.3281 1.875ZM15 26.0812C12.5766 24.5344 1.875 17.3062 1.875 10.5469C1.8762 9.1031 2.33712 7.69721 3.19095 6.53297C4.04477 5.36872 5.24715 4.50661 6.62383 4.07156C8.0005 3.63652 9.47994 3.65116 10.8477 4.11335C12.2155 4.57554 13.4006 5.46128 14.2313 6.64219C14.3178 6.76502 14.4326 6.86526 14.566 6.93445C14.6993 7.00364 14.8474 7.03975 14.9977 7.03975C15.1479 7.03975 15.296 7.00364 15.4293 6.93445C15.5627 6.86526 15.6775 6.76502 15.7641 6.64219C16.594 5.45925 17.7794 4.5716 19.148 4.10811C20.5167 3.64461 21.9975 3.6294 23.3755 4.06467C24.7534 4.49994 25.9567 5.36305 26.8108 6.52869C27.6649 7.69433 28.1252 9.10183 28.125 10.5469C28.125 17.3016 17.4234 24.5297 15 26.0812Z"
                                    :fill="prussianBlue()" />
                            </g>
                            <defs>
                                <clipPath id="clip0_197_15621">
                                    <rect width="30" height="30" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button> -->
                    <button @click="shareLink"
                        class="tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-bg-backgroundColor tdprb-border tdprb-border-borderColor hover:tdprb-text-backgroundColor hover:tdprb-bg-themeColor  hover:tdprb-border-borderColor tdprb-rounded-md tdprb-group">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="tdprb-fill-themeColor group-hover:tdprb-fill-backgroundColor"
                                d="M1.875 27.1875C1.80352 27.1875 1.73133 27.1793 1.65984 27.1629C1.2368 27.0621 0.9375 26.6848 0.9375 26.25C0.9375 17.7309 2.01516 10.6458 15 10.3235V3.75C15 3.37734 15.2205 3.04055 15.5613 2.89125C15.9009 2.74289 16.2991 2.80711 16.5738 3.06164L28.7613 14.3116C28.9535 14.4881 29.0625 14.7382 29.0625 15C29.0625 15.2618 28.9535 15.5119 28.7613 15.6886L16.5738 26.9386C16.3001 27.1931 15.9019 27.259 15.5613 27.109C15.2205 26.9595 15 26.6227 15 26.25V19.6985C6.09281 19.9118 4.44938 23.1977 2.71359 26.6693C2.55258 26.9925 2.22375 27.1875 1.875 27.1875ZM15.9375 17.8125C16.4557 17.8125 16.875 18.2318 16.875 18.75V24.1085L26.7427 15L16.875 5.89148V11.25C16.875 11.7682 16.4557 12.1875 15.9375 12.1875C5.58094 12.1875 3.35086 16.193 2.91234 22.5907C4.85414 19.9823 8.16375 17.8125 15.9375 17.8125Z"
                                fill="none" />
                        </svg>
                    </button>
                </div>
                <!-- add to cart  -->
                <div class="tdprb-w-full tdprb-mt-4 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[20px]">
                    <button :disabled="addToCartVar.loading"
                        class="tdprb-w-[400px] tdprb-h-[60px] tdprb-text-backgroundColor tdprb-bg-themeColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px]"
                        @click="!!selectedRingSize ? addToCart() : ringSizeError = true">
                        {{ addToCartVar.loading ? 'Adding to cart...' : settingTexts?.add_to_cart }}
                    </button>
                </div>

                <!-- services container  -->


                <div v-if="product_detail_texts['text1'] || product_detail_texts['text2'] || product_detail_texts['text3']"
                    class="tdprb-w-[90%] tdprb-mt-3 md:tdprb-mt-5 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-flex-col tdprb-gap-3">
                    <div v-if="product_detail_texts['text1']"
                        class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-2">
                        <div class="tdprb-w-[5%] tdprb-min-h-10 tdprb-flex tdprb-justify-center tdprb-items-start">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.4325 11.7L20.775 7.95C20.717 7.81701 20.6216 7.70371 20.5005 7.62384C20.3793 7.54396 20.2376 7.50095 20.0925 7.5H16.08L16.32 5.3325C16.3318 5.22728 16.3212 5.12075 16.2889 5.01992C16.2566 4.91909 16.2033 4.82625 16.1325 4.7475C16.0624 4.66981 15.9768 4.60765 15.8812 4.56502C15.7856 4.5224 15.6822 4.50025 15.5775 4.5H5.25C5.05109 4.5 4.86032 4.57902 4.71967 4.71967C4.57902 4.86032 4.5 5.05109 4.5 5.25C4.5 5.44891 4.57902 5.63968 4.71967 5.78033C4.86032 5.92098 5.05109 6 5.25 6H9C9.19891 6 9.38968 6.07902 9.53033 6.21967C9.67098 6.36032 9.75 6.55109 9.75 6.75C9.75 6.94891 9.67098 7.13968 9.53033 7.28033C9.38968 7.42098 9.19891 7.5 9 7.5H3.75C3.55109 7.5 3.36032 7.57902 3.21967 7.71967C3.07902 7.86032 3 8.05109 3 8.25C3 8.44891 3.07902 8.63968 3.21967 8.78033C3.36032 8.92098 3.55109 9 3.75 9H11.25C11.4489 9 11.6397 9.07902 11.7803 9.21967C11.921 9.36032 12 9.55109 12 9.75C12 9.94891 11.921 10.1397 11.7803 10.2803C11.6397 10.421 11.4489 10.5 11.25 10.5H6C5.80109 10.5 5.61032 10.579 5.46967 10.7197C5.32902 10.8603 5.25 11.0511 5.25 11.25C5.25 11.4489 5.32902 11.6397 5.46967 11.7803C5.61032 11.921 5.80109 12 6 12H9C9.19891 12 9.38968 12.079 9.53033 12.2197C9.67098 12.3603 9.75 12.5511 9.75 12.75C9.75 12.9489 9.67098 13.1397 9.53033 13.2803C9.38968 13.421 9.19891 13.5 9 13.5H3C2.80109 13.5 2.61032 13.579 2.46967 13.7197C2.32902 13.8603 2.25 14.0511 2.25 14.25C2.25 14.4489 2.32902 14.6397 2.46967 14.7803C2.61032 14.921 2.80109 15 3 15H4.5C4.69891 15 4.88968 15.079 5.03033 15.2197C5.17098 15.3603 5.25 15.5511 5.25 15.75C5.25 15.9489 5.17098 16.1397 5.03033 16.2803C4.88968 16.421 4.69891 16.5 4.5 16.5H3.75C3.55109 16.5 3.36032 16.579 3.21967 16.7197C3.07902 16.8603 3 17.0511 3 17.25C3 17.4489 3.07902 17.6397 3.21967 17.7803C3.36032 17.921 3.55109 18 3.75 18H5.8875C5.96849 18.3163 6.12262 18.6092 6.3375 18.855C6.51959 19.0586 6.74271 19.2213 6.99219 19.3325C7.24168 19.4436 7.51187 19.5007 7.785 19.5C8.24719 19.4868 8.69518 19.3374 9.07278 19.0705C9.45038 18.8037 9.74076 18.4313 9.9075 18H15.6375C15.7185 18.3163 15.8726 18.6092 16.0875 18.855C16.2696 19.0586 16.4927 19.2213 16.7422 19.3325C16.9917 19.4436 17.2619 19.5007 17.535 19.5C17.9972 19.4868 18.4452 19.3374 18.8228 19.0705C19.2004 18.8037 19.4908 18.4313 19.6575 18H21.1575C21.3429 18.0011 21.5222 17.9335 21.6607 17.8103C21.7992 17.687 21.8871 17.5168 21.9075 17.3325L22.485 12.0825C22.5056 11.9526 22.4873 11.8195 22.4325 11.7ZM7.785 18C7.72281 18.0027 7.66081 17.9913 7.60366 17.9666C7.54651 17.9419 7.49569 17.9046 7.455 17.8575C7.39613 17.7847 7.35305 17.7004 7.32852 17.61C7.30399 17.5196 7.29853 17.4251 7.3125 17.3325C7.33166 17.1219 7.42257 16.9243 7.57003 16.7728C7.71748 16.6212 7.91252 16.5249 8.1225 16.5C8.18469 16.4973 8.24669 16.5087 8.30384 16.5334C8.36099 16.5581 8.41181 16.5954 8.4525 16.6425C8.51137 16.7153 8.55445 16.7996 8.57898 16.89C8.60351 16.9804 8.60897 17.0749 8.595 17.1675C8.57584 17.3781 8.48493 17.5757 8.33747 17.7272C8.19002 17.8788 7.99498 17.9751 7.785 18ZM17.535 18C17.4728 18.0027 17.4108 17.9913 17.3537 17.9666C17.2965 17.9419 17.2457 17.9046 17.205 17.8575C17.1461 17.7847 17.1031 17.7004 17.0785 17.61C17.054 17.5196 17.0485 17.4251 17.0625 17.3325C17.0817 17.1219 17.1726 16.9243 17.32 16.7728C17.4675 16.6212 17.6625 16.5249 17.8725 16.5C17.9347 16.4973 17.9967 16.5087 18.0538 16.5334C18.111 16.5581 18.1618 16.5954 18.2025 16.6425C18.2614 16.7153 18.3044 16.7996 18.329 16.89C18.3535 16.9804 18.359 17.0749 18.345 17.1675C18.3258 17.3781 18.2349 17.5757 18.0875 17.7272C17.94 17.8788 17.745 17.9751 17.535 18ZM20.91 12.75H17.595C17.4903 12.7498 17.3869 12.7276 17.2913 12.685C17.1957 12.6424 17.1101 12.5802 17.04 12.5025C16.9692 12.4237 16.9159 12.3309 16.8836 12.2301C16.8513 12.1292 16.8407 12.0227 16.8525 11.9175L17.1 9.6675C17.1221 9.48457 17.2108 9.31617 17.3491 9.19445C17.4874 9.07272 17.6657 9.00617 17.85 9.0075H19.5975L21 12.12L20.91 12.75Z"
                                        :fill="prussianBlue()" />
                                    <path
                                        d="M3 12C3.19891 12 3.38968 11.921 3.53033 11.7803C3.67098 11.6397 3.75 11.4489 3.75 11.25C3.75 11.0511 3.67098 10.8603 3.53033 10.7197C3.38968 10.579 3.19891 10.5 3 10.5H2.25C2.05109 10.5 1.86032 10.579 1.71967 10.7197C1.57902 10.8603 1.5 11.0511 1.5 11.25C1.5 11.4489 1.57902 11.6397 1.71967 11.7803C1.86032 11.921 2.05109 12 2.25 12H3Z"
                                        :fill="prussianBlue()" />
                                </svg>
                            </span>
                        </div>
                        <div class="tdprb-w-[95%] tdprb-min-h-10 tdprb-flex tdprb-justify-start tdprb-items-start">
                            <p>{{ product_detail_texts['text1'] }}</p>
                        </div>
                    </div>
                    <div v-if="product_detail_texts['text2']"
                        class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-2">
                        <div class="tdprb-w-[5%] tdprb-min-h-10 tdprb-flex tdprb-justify-center tdprb-items-start">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.5 7.5V5.25C22.5 4.65326 22.2629 4.08097 21.841 3.65901C21.419 3.23705 20.8467 3 20.25 3H17.25V2.25C17.25 2.05109 17.171 1.86032 17.0303 1.71967C16.8897 1.57902 16.6989 1.5 16.5 1.5C16.3011 1.5 16.1103 1.57902 15.9697 1.71967C15.829 1.86032 15.75 2.05109 15.75 2.25V3H8.25V2.25C8.25 2.05109 8.17098 1.86032 8.03033 1.71967C7.88968 1.57902 7.69891 1.5 7.5 1.5C7.30109 1.5 7.11032 1.57902 6.96967 1.71967C6.82902 1.86032 6.75 2.05109 6.75 2.25V3H3.75C3.15326 3 2.58097 3.23705 2.15901 3.65901C1.73705 4.08097 1.5 4.65326 1.5 5.25V7.5H22.5Z"
                                        :fill="prussianBlue()" />
                                    <path
                                        d="M1.5 9V20.25C1.5 20.8467 1.73705 21.419 2.15901 21.841C2.58097 22.2629 3.15326 22.5 3.75 22.5H20.25C20.8467 22.5 21.419 22.2629 21.841 21.841C22.2629 21.419 22.5 20.8467 22.5 20.25V9H1.5ZM16.2375 13.3193L10.9875 17.8193C10.844 17.9419 10.6595 18.006 10.4708 17.9986C10.2822 17.9913 10.1032 17.913 9.96975 17.7795L7.71975 15.5295C7.58313 15.388 7.50754 15.1986 7.50924 15.0019C7.51095 14.8053 7.58983 14.6172 7.72889 14.4781C7.86794 14.3391 8.05605 14.2602 8.2527 14.2585C8.44935 14.2568 8.6388 14.3324 8.78025 14.469L10.5398 16.2285L15.2648 12.1785C15.3391 12.1115 15.4261 12.06 15.5207 12.0272C15.6153 11.9943 15.7155 11.9807 15.8154 11.9872C15.9153 11.9936 16.0129 12.02 16.1024 12.0648C16.1919 12.1096 16.2716 12.1719 16.3367 12.2479C16.4018 12.324 16.451 12.4123 16.4814 12.5077C16.5118 12.6031 16.5229 12.7036 16.5138 12.8033C16.5048 12.903 16.4759 12.9999 16.4288 13.0882C16.3817 13.1766 16.3175 13.2546 16.2397 13.3177L16.2375 13.3193Z"
                                        :fill="prussianBlue()" />
                                </svg>
                            </span>
                        </div>
                        <div class="tdprb-w-[95%] tdprb-min-h-10 tdprb-flex tdprb-justify-start tdprb-items-start">
                            <p>{{ product_detail_texts['text2'] }}</p>
                        </div>
                    </div>
                    <div v-if="product_detail_texts['text3']"
                        class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-2">
                        <div class="tdprb-w-[5%] tdprb-min-h-10 tdprb-flex tdprb-justify-center tdprb-items-start">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_197_15614)">
                                        <path
                                            d="M22.244 9.95907C22.1779 6.51376 21.6979 3.97267 21.7045 3.97032C21.5048 3.58079 21.1546 3.25501 20.7262 3.0886C17.9137 1.99782 15.1481 0.956729 12.4518 0.0684473C12.1762 -0.0224902 11.8856 -0.0224902 11.6104 0.0684473C8.91464 0.954385 6.14948 1.9936 3.33745 3.08298C2.95917 3.2297 2.64182 3.5011 2.43511 3.8311C2.45104 3.83298 1.85714 5.68688 1.75589 9.78142C1.69589 13.8764 2.20589 15.1031 2.18901 15.1045C2.46511 16.0045 2.98167 16.92 3.72182 17.8509C4.54917 18.8906 5.66714 19.9645 7.01761 21.0202C9.25307 22.7747 11.3451 23.8233 11.4328 23.8603C11.6226 23.9531 11.8237 24.0005 12.0309 24C12.2385 24 12.4396 23.9527 12.629 23.8594C12.7171 23.8224 14.8115 22.7705 17.046 21.0164C18.397 19.9599 19.5149 18.8859 20.3428 17.8467C21.1359 16.8497 21.6721 15.8714 21.9314 14.9105C21.921 14.9091 22.296 13.4053 22.244 9.95954V9.95907ZM13.1437 12.6464V14.8294C13.1437 15.4444 12.6454 15.9427 12.0304 15.9431C11.4154 15.9431 10.9167 15.4449 10.9167 14.8299V12.6774C10.1142 12.2784 9.56198 11.4506 9.56198 10.4939C9.56198 9.14767 10.6532 8.05595 11.9995 8.05595C13.3457 8.05595 14.437 9.1472 14.4374 10.4934C14.4374 11.4263 13.9134 12.2367 13.1437 12.6464Z"
                                            :fill="prussianBlue()" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_197_15614">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </div>
                        <div class="tdprb-w-[95%] tdprb-min-h-10 tdprb-flex tdprb-justify-start tdprb-items-start">
                            <p>{{ product_detail_texts['text3'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Uniquely Yours container  -->
                <div class="tdprb-min-h-[10px] tdprb-mt-3 md:tdprb-mt-5 tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-[20px] tdprb-overflow-hidden tdprb-rounded-md tdprb-relative tdprb-group tdprb-cursor-pointer"
                    v-if="!!setting_details_ad.link && !!setting_details_ad.redirect_link">

                    <!-- Shine effect, only visible and animates once on hover -->
                    <div
                        class="tdprb-absolute tdprb-top-0 tdprb-w-full tdprb-h-full tdprb-bg-shine-gradient tdprb-opacity-0 group-hover:tdprb-opacity-100 group-hover:tdprb-animate-shine-hover-once tdprb-transition-opacity">
                    </div>
                    <img :title="setting_details_ad.redirect_link" @click="openLink(setting_details_ad.redirect_link)"
                        class="tdprb-h-full tdprb-w-full tdprb-object-cover tdprb-cursor-pointer"
                        :src="setting_details_ad.link">
                </div>

                <!-- setting information table -->
                <SettingInfoTable v-if="headerData.length" :headers="headerData" :data="product" />

                <!-- settings buttons container  -->

                <div v-if="details_page_links['virtual_consultation_link'] || details_page_links['book_appointment_link']"
                    class="tdprb-w-full md:tdprb-mt-5 tdprb-mt-3 tdprb-flex md:tdprb-flex-row tdprb-flex-col tdprb-justify-center tdprb-items-center md:tdprb-gap-[20px] tdprb-gap-[10px] md:tdprb-pt-[20px] tdprb-pt-[10px] tdprb-border-t tdprb-border-t-borderColor">
                    <!-- <button
                        class="tdprb-w-full tdprb-h-[60px] tdprb-border tdprb-border-borderColor tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[15px] tdprb-font-[500] tdprb-leading-[22.5px] tdprb-gap-[20px]">
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_197_16082)">
                                    <path
                                        d="M25.9716 11.465C24.556 10.8988 22.9141 11.5237 22.2335 12.8869L21.251 14.8525V4.375C21.251 2.99625 20.1297 1.875 18.751 1.875C18.2897 1.875 17.8566 2.00063 17.4854 2.21938C17.3454 0.9725 16.2847 0 15.001 0C13.6222 0 12.501 1.12125 12.501 2.5V2.83563C12.1329 2.6225 11.706 2.5 11.251 2.5C9.87223 2.5 8.75098 3.62125 8.75098 5V5.96062C8.38285 5.7475 7.95598 5.625 7.50098 5.625C6.12223 5.625 5.00098 6.74625 5.00098 8.125V17.2087C5.00098 18.7356 5.3216 20.2156 5.95348 21.6056L8.12598 26.385V28.1244C8.12598 29.1581 8.96723 29.9994 10.001 29.9994H18.751C19.7847 29.9994 20.626 29.1581 20.626 28.1244V26.4756L22.5197 24.2019C23.286 23.2844 23.8866 22.2506 24.3066 21.1306L27.031 13.8637C27.386 12.9169 26.911 11.8412 25.9716 11.465ZM9.37535 13.125V11.875H13.1254V13.125H9.37535ZM10.0004 5C10.0004 4.31063 10.561 3.75 11.2504 3.75C11.9397 3.75 12.5004 4.31063 12.5004 5V10.625H10.0004V5ZM25.8604 13.4256L23.136 20.6925C22.7654 21.6806 22.2354 22.5925 21.5597 23.4025L19.5204 25.85C19.4272 25.9625 19.376 26.1031 19.376 26.25V28.125C19.376 28.47 19.096 28.75 18.751 28.75H10.001C9.65598 28.75 9.37598 28.47 9.37598 28.125V26.25C9.37598 26.1606 9.35723 26.0725 9.31973 25.9912L7.0916 21.0881C6.53348 19.8612 6.25098 18.5562 6.25098 17.2087V8.125C6.25098 7.43563 6.8116 6.875 7.50098 6.875C8.19035 6.875 8.75098 7.43563 8.75098 8.125V10.7987C8.3791 11.0156 8.12598 11.4144 8.12598 11.875V13.125C8.12598 13.5856 8.3791 13.9844 8.75098 14.2013V15.625C8.75098 15.9706 9.03035 16.25 9.37598 16.25C9.7216 16.25 10.001 15.9706 10.001 15.625V14.375H12.501V15.625C12.501 15.9706 12.7804 16.25 13.126 16.25C13.4716 16.25 13.751 15.9706 13.751 15.625V14.2013C14.1229 13.9844 14.376 13.5856 14.376 13.125V11.875C14.376 11.4144 14.1229 11.0156 13.751 10.7987V2.5C13.751 1.81062 14.3116 1.25 15.001 1.25C15.6904 1.25 16.251 1.81062 16.251 2.5V15.625C16.251 15.9706 16.5304 16.25 16.876 16.25C17.2216 16.25 17.501 15.9706 17.501 15.625V4.375C17.501 3.68563 18.0616 3.125 18.751 3.125C19.4404 3.125 20.001 3.68563 20.001 4.375V17.5C20.001 17.79 20.2004 18.0413 20.4829 18.1088C20.7616 18.1731 21.056 18.0394 21.1854 17.78L23.3522 13.4462C23.7454 12.66 24.6941 12.3019 25.5079 12.6262C25.821 12.7519 25.9797 13.1106 25.861 13.4263L25.8604 13.4256Z"
                                        :fill="prussianBlue()" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_197_16082">
                                        <rect width="30" height="30" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <span>
                            Try in your hand
                        </span>
                    </button> -->

                    <button v-if="details_page_links['book_appointment_link']"
                        @click="openLink(details_page_links['book_appointment_link'])"
                        class="md:tdprb-w-1/2 tdprb-w-full tdprb-h-[60px] tdprb-border tdprb-border-borderColor tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-backgroundColor hover:tdprb-bg-themeColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[15px] tdprb-font-[500] tdprb-leading-[22.5px] tdprb-gap-[20px] tdprb-group">
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="tdprb-fill-themeColor group-hover:tdprb-fill-backgroundColor"
                                    d="M5.625 18.75C5.625 18.5014 5.72377 18.2629 5.89959 18.0871C6.0754 17.9113 6.31386 17.8125 6.5625 17.8125H8.4375V15.9375C8.4375 15.6889 8.53627 15.4504 8.71209 15.2746C8.8879 15.0988 9.12636 15 9.375 15C9.62364 15 9.8621 15.0988 10.0379 15.2746C10.2137 15.4504 10.3125 15.6889 10.3125 15.9375V17.8125H12.1875C12.4361 17.8125 12.6746 17.9113 12.8504 18.0871C13.0262 18.2629 13.125 18.5014 13.125 18.75C13.125 18.9986 13.0262 19.2371 12.8504 19.4129C12.6746 19.5887 12.4361 19.6875 12.1875 19.6875H10.3125V21.5625C10.3125 21.8111 10.2137 22.0496 10.0379 22.2254C9.8621 22.4012 9.62364 22.5 9.375 22.5C9.12636 22.5 8.8879 22.4012 8.71209 22.2254C8.53627 22.0496 8.4375 21.8111 8.4375 21.5625V19.6875H6.5625C6.31386 19.6875 6.0754 19.5887 5.89959 19.4129C5.72377 19.2371 5.625 18.9986 5.625 18.75ZM21.5625 23.4375H23.4375C23.6861 23.4375 23.9246 23.3387 24.1004 23.1629C24.2762 22.9871 24.375 22.7486 24.375 22.5C24.375 22.2514 24.2762 22.0129 24.1004 21.8371C23.9246 21.6613 23.6861 21.5625 23.4375 21.5625H21.5625C21.3139 21.5625 21.0754 21.6613 20.8996 21.8371C20.7238 22.0129 20.625 22.2514 20.625 22.5C20.625 22.7486 20.7238 22.9871 20.8996 23.1629C21.0754 23.3387 21.3139 23.4375 21.5625 23.4375ZM21.5625 15.9375H23.4375C23.6861 15.9375 23.9246 15.8387 24.1004 15.6629C24.2762 15.4871 24.375 15.2486 24.375 15C24.375 14.7514 24.2762 14.5129 24.1004 14.3371C23.9246 14.1613 23.6861 14.0625 23.4375 14.0625H21.5625C21.3139 14.0625 21.0754 14.1613 20.8996 14.3371C20.7238 14.5129 20.625 14.7514 20.625 15C20.625 15.2486 20.7238 15.4871 20.8996 15.6629C21.0754 15.8387 21.3139 15.9375 21.5625 15.9375ZM15.9375 15.9375H17.8125C18.0611 15.9375 18.2996 15.8387 18.4754 15.6629C18.6512 15.4871 18.75 15.2486 18.75 15C18.75 14.7514 18.6512 14.5129 18.4754 14.3371C18.2996 14.1613 18.0611 14.0625 17.8125 14.0625H15.9375C15.6889 14.0625 15.4504 14.1613 15.2746 14.3371C15.0988 14.5129 15 14.7514 15 15C15 15.2486 15.0988 15.4871 15.2746 15.6629C15.4504 15.8387 15.6889 15.9375 15.9375 15.9375ZM21.5625 19.6875H23.4375C23.6861 19.6875 23.9246 19.5887 24.1004 19.4129C24.2762 19.2371 24.375 18.9986 24.375 18.75C24.375 18.5014 24.2762 18.2629 24.1004 18.0871C23.9246 17.9113 23.6861 17.8125 23.4375 17.8125H21.5625C21.3139 17.8125 21.0754 17.9113 20.8996 18.0871C20.7238 18.2629 20.625 18.5014 20.625 18.75C20.625 18.9986 20.7238 19.2371 20.8996 19.4129C21.0754 19.5887 21.3139 19.6875 21.5625 19.6875ZM28.125 7.5V25.3125C28.125 26.0584 27.8287 26.7738 27.3012 27.3012C26.7738 27.8287 26.0584 28.125 25.3125 28.125H4.6875C3.94158 28.125 3.22621 27.8287 2.69876 27.3012C2.17132 26.7738 1.875 26.0584 1.875 25.3125V7.5C1.875 6.75408 2.17132 6.03871 2.69876 5.51126C3.22621 4.98382 3.94158 4.6875 4.6875 4.6875H5.625V2.8125C5.625 2.56386 5.72377 2.3254 5.89959 2.14959C6.0754 1.97377 6.31386 1.875 6.5625 1.875C6.81114 1.875 7.0496 1.97377 7.22541 2.14959C7.40123 2.3254 7.5 2.56386 7.5 2.8125V4.6875H22.5V2.8125C22.5 2.56386 22.5988 2.3254 22.7746 2.14959C22.9504 1.97377 23.1889 1.875 23.4375 1.875C23.6861 1.875 23.9246 1.97377 24.1004 2.14959C24.2762 2.3254 24.375 2.56386 24.375 2.8125V4.6875H25.3125C26.0584 4.6875 26.7738 4.98382 27.3012 5.51126C27.8287 6.03871 28.125 6.75408 28.125 7.5ZM26.25 11.25H3.75V25.3125C3.75 25.5611 3.84877 25.7996 4.02459 25.9754C4.2004 26.1512 4.43886 26.25 4.6875 26.25H25.3125C25.5611 26.25 25.7996 26.1512 25.9754 25.9754C26.1512 25.7996 26.25 25.5611 26.25 25.3125V11.25ZM26.25 7.5C26.25 7.25136 26.1512 7.0129 25.9754 6.83709C25.7996 6.66127 25.5611 6.5625 25.3125 6.5625H4.6875C4.43886 6.5625 4.2004 6.66127 4.02459 6.83709C3.84877 7.0129 3.75 7.25136 3.75 7.5V9.375H26.25V7.5ZM15.9375 23.4375H17.8125C18.0611 23.4375 18.2996 23.3387 18.4754 23.1629C18.6512 22.9871 18.75 22.7486 18.75 22.5C18.75 22.2514 18.6512 22.0129 18.4754 21.8371C18.2996 21.6613 18.0611 21.5625 17.8125 21.5625H15.9375C15.6889 21.5625 15.4504 21.6613 15.2746 21.8371C15.0988 22.0129 15 22.2514 15 22.5C15 22.7486 15.0988 22.9871 15.2746 23.1629C15.4504 23.3387 15.6889 23.4375 15.9375 23.4375ZM15.9375 19.6875H17.8125C18.0611 19.6875 18.2996 19.5887 18.4754 19.4129C18.6512 19.2371 18.75 18.9986 18.75 18.75C18.75 18.5014 18.6512 18.2629 18.4754 18.0871C18.2996 17.9113 18.0611 17.8125 17.8125 17.8125H15.9375C15.6889 17.8125 15.4504 17.9113 15.2746 18.0871C15.0988 18.2629 15 18.5014 15 18.75C15 18.9986 15.0988 19.2371 15.2746 19.4129C15.4504 19.5887 15.6889 19.6875 15.9375 19.6875Z"
                                    fill="none" />
                            </svg>
                        </span>
                        <span>
                            Book an Appointment
                        </span>
                    </button>
                    <button v-if="details_page_links['virtual_consultation_link']"
                        @click="openLink(details_page_links['virtual_consultation_link'])"
                        class="md:tdprb-w-1/2 tdprb-w-full tdprb-h-[60px] tdprb-border tdprb-border-borderColor tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-backgroundColor hover:tdprb-bg-themeColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded-md tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-lato tdprb-text-[15px] tdprb-font-[500] tdprb-leading-[22.5px] tdprb-gap-[20px] tdprb-group">
                        <span>
                            <svg width="30" height="27" viewBox="0 0 30 27" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="tdprb-fill-themeColor group-hover:tdprb-fill-backgroundColor"
                                    fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.4886 0.130806C15.1866 -0.0436019 14.8144 -0.0436019 14.5124 0.130806L7.66585 4.08365C7.36382 4.25802 7.17773 4.58029 7.17773 4.92906V12.8347C7.17773 13.1835 7.36382 13.5058 7.66585 13.6802L14.5124 17.633C14.8144 17.8074 15.1866 17.8074 15.4886 17.633L22.3351 13.6802C22.6372 13.5058 22.8232 13.1835 22.8232 12.8347V4.92906C22.8232 4.58029 22.6372 4.25802 22.3351 4.08365L15.4886 0.130806ZM9.1302 12.2711V6.61982L14.0243 9.44541V15.0967L9.1302 12.2711ZM15.0005 7.75454L10.1065 4.92899L15.0005 2.10351L19.957 4.96511L15.0005 7.75454ZM15.9767 9.45202L20.8708 6.69259V12.2711L15.9767 15.0967V9.45202Z"
                                    fill="none" />
                                <path class="tdprb-fill-themeColor group-hover:tdprb-fill-backgroundColor"
                                    d="M1.95247 4.09916C1.95247 2.97939 2.86022 2.0716 3.98003 2.0716H7.22773C7.76691 2.0716 8.20396 1.63455 8.20396 1.09537C8.20396 0.55623 7.76691 0.119141 7.22773 0.119141H3.98003C1.78193 0.119141 0 1.90106 0 4.09916V17.6674C0 19.8655 1.78193 21.6474 3.98003 21.6474H14.0238V24.9345H8.11389C7.57474 24.9345 7.13765 25.3716 7.13765 25.9107C7.13765 26.4499 7.57474 26.887 8.11389 26.887H21.8865C22.4256 26.887 22.8627 26.4499 22.8627 25.9107C22.8627 25.3716 22.4256 24.9345 21.8865 24.9345H15.9763V21.6474H26.02C28.2181 21.6474 30 19.8655 30 17.6674V4.09916C30 1.90106 28.2181 0.119141 26.02 0.119141H22.758C22.2189 0.119141 21.7818 0.55623 21.7818 1.09537C21.7818 1.63455 22.2189 2.0716 22.758 2.0716H26.02C27.1398 2.0716 28.0475 2.97939 28.0475 4.09916V17.6674C28.0475 18.7872 27.1398 19.695 26.02 19.695H3.98003C2.86022 19.695 1.95247 18.7872 1.95247 17.6674V4.09916Z"
                                    fill="none" />
                            </svg>
                        </span>
                        <span>
                            Virtual Consultation
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>
<script>

import axios from 'axios'

export default {
    data() {
        return {
            popup: {
                timer: null,
                status: false,
                message: null,
            },
            addToCartVar: {
                timer: null,
                loading: false,
                error: false,
                message: null,
            },
            imageSrc: null,
            routerID: this.$route.params?.id,
            selectedMetal: null,
            ringSizeData: [],
            setting_details_ad: {},
            selectedRingSize: null,
            ringSizeError: false,
            isLoading: true, // Flag to track loading state
            isError: false, // Flag to track loading state
            imageStates: [],
            settingTexts: {},
            product: {},
            headerData: {},
            activeSubSection: 1,
            subImageSection: [],
            allMetals: {},
            selectedDiamondShape: null,
            diamondShapes: [],
        }
    },
    mounted() {
        this.$backToTop();
        this.imageStates = this.subImageSection.map(() => ({
            isLoading: true,
            isError: false,
        }))
    },
    computed: {
        ringSizeCountryCode() {
            return this.$store.getters['settingSettings/ringSize']
        },
        product_advertisement_links() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('product_advertisement_links');
        },
        details_page_links() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('details_page_links');
        },
        product_detail_texts() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('product_detail_texts');
        },
        settingDataFromCompleteRing() {
            return this.$store.getters['completeRing/getSettingData'];
        },
        diamondDataFromCompleteRing() {
            return this.$store.getters['completeRing/getDiamondData'];
        },
        detailsCustomization() {
            return this.$store.getters['settingSettings/detailsCustomization'];
        },
        // 0.70 Carat Emerald Lab Diamond
        title() {
            return this.product.product_name;
        },
        setting_texts() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('setting_texts');
        },
        settingData() {
            return this.$store.getters['settingDetailsApi/settingData']
        },
        all_metals() {
            return this.$store.getters['settingDetailsApi/all_metals']
        },
        loading() {
            return this.$store.getters['settingDetailsApi/loading']
        },
        dataNotFound() {
            return this.$store.getters['settingDetailsApi/dataNotFound']
        },
        dataNotFoundMsg() {
            return this.$store.getters['settingDetailsApi/dataNotFoundMsg']
        },
    },
    methods: {
        changeDiamondShape(shape) {
            this.selectedDiamondShape = shape;
        },
        prussianBlue() {
            return this.$colors().prussianBlue;
        },
        checkImageCache(imageSrc) {
            const img = new Image();
            img.src = imageSrc;

            // If the image is already cached, it will trigger the `onLoad` immediately
            if (img.complete) {
                this.onLoad();
            } else {
                this.isLoading = true;
            }
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {
            return this.$increasePriceByPercentage(price, 20)
        },
        getRingSizeData(countryCode) {
            return this.$getRingSizesByCountry(countryCode)
        },
        openLink(link) {
            window.open(link, '_blank');
        },
        shareLink() {
            // copy the current page link and log the link
            var link = window.location.href;
            var copyText = document.createElement("textarea");
            copyText.value = link;
            document.body.appendChild(copyText);
            copyText.select();
            document.execCommand("copy");
            document.body.removeChild(copyText);

            this.popup.status = true;
            this.popup.message = 'Link copied to clipboard';

            clearTimeout(this.popup.timer);
            this.popup.timer = setTimeout(() => {
                this.popup.status = false;
                this.popup.message = null;
            }, 2000);
        },
        updateRingSize(value) {
            this.selectedRingSize = value
        },
        updateMetal(value) {
            this.selectedMetal = value
        },
        async addToCart() {

            this.addToCartVar.loading = true;
            this.addToCartVar.error = false;
            this.addToCartVar.message = null;

            // adding the productURL to the data 
            this.product.productURL = window.location.href
            // adding metal 
            this.product.selectedMetal = this.selectedMetal
            // adding ring size
            this.product.selectedRingSize = this.selectedRingSize

            const actionUrl = this.$isDevelopmentMode ? this.$defaultAjaxUrl : tdprbajax.ajaxurl;
            const data = new FormData();
            data.append('action', this.$apiActions.settingAddToCartApi);
            !this.$isDevelopmentMode && data.append("nonce", tdprbajax.nonce);
            data.append('settingData', JSON.stringify(this.product));

            try {
                const response = await axios.post(actionUrl, data);
                this.addToCartVar.loading = false;

                if (response.data.status) {
                    if (!!response.data.cart_url) {
                        window.location.href = response.data.cart_url;
                    } else {
                        this.addToCartVar.loading = false;
                        this.addToCartVar.message = response.data.message;
                        console.error('product url not found');
                    }
                } else {
                    this.addToCartVar.error = true;
                    this.addToCartVar.message = response.data.message;
                    console.error(response.data.message);
                }
            } catch (error) {
                this.addToCartVar.loading = false;
                this.addToCartVar.error = true;
                this.addToCartVar.message = error;
                console.error(error);
            }
        },
        onSubImageLoad(index) {
            this.imageStates[index] = { isLoading: false, isError: false };
        },
        onSubImageError(index) {
            this.imageStates[index] = { isLoading: false, isError: true };
        },
        onLoad() {
            this.isLoading = false; // Hide loader when content is loaded
            this.isError = false; // Handle error and hide loader
        },
        onError() {
            this.isLoading = false; // Handle error and hide loader
            this.isError = true; // Handle error and hide loader
        },
        backToSearch() {
            this.$router.push({ name: 'SettingListPage' });
        },
        callDetailPageApi(id) {
            this.$store.dispatch('settingDetailsApi/fetchSettingDetail', { id });
        },
        setSettingDataToCompleteRing() {
            const data = this.product

            // adding the current route page name to the data
            data.toName = this.$router.currentRoute.value.name
            // adding the productURL to the data 
            data.productURL = window.location.href
            // adding metal 
            data.selectedMetal = this.selectedMetal
            // adding ring size
            data.selectedRingSize = this.selectedRingSize

            this.$store.dispatch('completeRing/setSettingData', data);
            if (this.isEmptyObject(this.diamondDataFromCompleteRing)) {
                this.$router.push({ name: 'DiamondListPage' });
            } else {
                this.$router.push({ name: 'CompleteRingPage' });
            }
        },
        isEmptyObject(obj) {
            if (!!obj) {
                return Object.keys(obj).length === 0 && obj.constructor === Object;
            } else {
                return true;
            }
        },
        updateSettingData(field, value) {
            const changedData = this.product
            const data = this.settingDataFromCompleteRing
            changedData["selectedRingSize"] = data?.selectedRingSize
            changedData[field] = value
            this.$store.dispatch('completeRing/setSettingData', changedData);
        },
        setSubMedia(data) {
            return [
                { src: data?.video, type: 'video' },
                { src: data?.main_image, type: 'image' },
                { src: data?.additional_image_1, type: 'image' },
                { src: data?.additional_image_2, type: 'image' },
                { src: data?.additional_image_3, type: 'image' },
                { src: data?.additional_image_4, type: 'image' },
                { src: data?.additional_image_5, type: 'image' },
            ];
        },
        // isSameData() {
        //     return this.routerID == this.settingDataFromCompleteRing?.sku
        // }
    },
    watch: {
        ringSizeCountryCode: {
            immediate: true,
            handler(value) {
                if (!!value) {
                    this.ringSizeData = this.getRingSizeData(value)
                }
            }
        },
        product_advertisement_links: {
            handler(newVal) {
                if (newVal) {
                    if (!this.isEmptyObject(newVal['setting_details_ad'])) {
                        this.setting_details_ad = newVal?.setting_details_ad || {};
                    }
                }
            },
            immediate: true,
            deep: true
        },
        'addToCartVar.error': {
            handler(val) {
                if (val) {
                    clearTimeout(this.addToCartVar.timer);
                    this.addToCartVar.timer = setTimeout(() => {
                        this.addToCartVar.error = false;
                        this.addToCartVar.message = null;
                    }, 2000);
                }
            },
            immediate: true,
            deep: true
        },
        activeSubSection: {
            handler(val) {
                const image = this.subImageSection[val]?.src
                if (image) {
                    this.checkImageCache(image);
                }
            },
            immediate: true,
            deep: true
        },
        // subImageSection: {
        //     handler(val) {
        //         this.imageStates = this.subImageSection.map(() => ({
        //             isLoading: true,
        //             isError: false,
        //         }))
        //     },
        //     immediate: true,
        //     deep: true
        // },
        detailsCustomization: {
            handler(newVal) {
                if (newVal) {
                    this.headerData = newVal
                }
            },
            immediate: true,
            deep: true
        },
        settingData: {
            handler(newVal) {
                if (this.routerID == this.settingDataFromCompleteRing?.sku) {
                    const data = this.settingDataFromCompleteRing
                    this.product = data
                    this.subImageSection = this.setSubMedia(data)
                    this.selectedMetal = data?.selectedMetal
                    this.selectedRingSize = data?.selectedRingSize
                    this.diamondShapes = data?.diamond_can_be_matched_with
                } else {
                    if (newVal) {
                        this.product = newVal
                        this.subImageSection = this.setSubMedia(this.product)
                        this.selectedMetal = newVal?.metal_name
                        this.selectedRingSize = newVal?.selectedRingSize
                        this.diamondShapes = newVal?.diamond_can_be_matched_with
                    }
                }
            },
            immediate: true,
            deep: true
        },
        selectedRingSize: {
            immediate: true,
            handler(value) {
                if (!!value) {
                    this.ringSizeError = false
                    if (this.routerID == this.settingDataFromCompleteRing?.sku) {
                        this.updateSettingData('selectedRingSize', value)
                    }
                }

            }
        },
        selectedMetal: {
            immediate: true,
            handler(value) {
                if (!!value && !this.isEmptyObject(this.allMetals)) {
                    this.product = this.allMetals?.values[value];
                    // adding the current route page name to the data
                    this.product.toName = this.$router.currentRoute.value.name
                    // adding the productURL to the data 
                    this.product.productURL = window.location.href
                    // adding metal 
                    this.product.selectedMetal = this.selectedMetal
                    // adding ring size
                    this.product.selectedRingSize = this.selectedRingSize
                    const data = this.settingDataFromCompleteRing
                    this.selectedRingSize = data?.selectedRingSize
                    this.selectedRingSize = data?.selectedRingSize
                    this.subImageSection = this.setSubMedia(this.product);
                    this.diamondShapes = this.product?.diamond_can_be_matched_with
                }

                if (!!value) {
                    // Update routerID if it matches the SKU of setting data
                    this.updateSettingData('selectedMetal', value);

                    // Update routerID to the new value
                    this.routerID = value;  // Change this line to the desired logic for setting routerID
                    // Optionally, you can navigate to the new route if needed
                    this.$router.push({ path: `/setting-details/${this.product.sku}` });
                }
            }
        },
        '$route': {
            handler(to, from) {
                if (to.params.id) {
                    this.routerID = to.params.id;
                    this.product.sku != this.routerID && (this.settingData == null || this.settingData.sku != to.params.id) && this.callDetailPageApi(to.params.id)
                }
            },
            immediate: true
        },
        setting_texts: {
            handler(newVal, oldVal) {
                this.settingTexts = newVal;
            },
            deep: true,
            immediate: true
        },
        all_metals: {
            handler(newVal) {
                if (!this.isEmptyObject(newVal)) {
                    const data = newVal
                    localStorage.setItem("tdp-rb-all-metals", JSON.stringify(data))
                    this.allMetals.keys = Object.keys(newVal);
                    this.allMetals.values = newVal;
                } else {
                    const data = JSON.parse(localStorage.getItem("tdp-rb-all-metals")) || []
                    this.allMetals.keys = Object.keys(data);
                    this.allMetals.values = data;
                }
            },
            deep: true,
            immediate: true
        }
    }
}
</script>
<style lang="">

</style>