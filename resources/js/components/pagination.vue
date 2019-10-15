<template v-if="pagesCount > 1">
    <ul class="pagination">
        <li :aria-disabled="{true: currentPageNumber === 1}" aria-label="Previous" class="page-item" :class="{'disabled': currentPageNumber === 1}">
            <span class="page-link" @click="selectResultsPage(1)">
                <i class="fal fa-chevron-double-left"></i>
            </span>
        </li>
        <li :aria-disabled="{true: currentPageNumber === 1}" aria-label="Previous" class="page-item" :class="{'disabled': currentPageNumber === 1}">
            <span class="page-link" @click="selectResultsPage(currentPageNumber - 1)">
                <i class="fal fa-chevron-left"></i>
            </span>
        </li>
        <template v-if="pagesCount <= 10">
            <li v-for="(n,index) in pagesCount" class="page-item" :class="{'active' : currentPageNumber === n}" @click="selectResultsPage(n)">
                <span v-if="n" class="page-link">{{n}}</span>
            </li>
        </template>
        <template>
            <li v-for="(n,index) in items" class="page-item" :class="{'active' : currentPageNumber === n}" @click="selectResultsPage(n)">
                <span v-if="n" class="page-link">{{n}}</span>
            </li>
            <template v-if="currentPageNumber !== pagesCount">
                <span class="d-flex align-self-center ml-3 mr-3">
                    <i class="far fa-ellipsis-h"></i>
                </span>
                <li class="page-item" :class="{'active' : currentPageNumber === pagesCount}" @click="selectResultsPage(pagesCount)">
                    <span class="page-link">{{pagesCount}}</span>
                </li>
            </template>
        </template>
        <li :aria-disabled="{true: currentPageNumber === pagesCount}" class="page-item" :class="{'disabled': currentPageNumber === pagesCount}">
            <span class="page-link" @click="selectResultsPage(currentPageNumber + 1)">
                    <i class="fal fa-chevron-right"></i>
            </span>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "pagination",
        props: ['pagesCount', 'currentPageNumber'],
        computed: {
            items() {
                if(this.currentPageNumber < 3) {
                    return [1,2,3,4,5];
                } else {
                    if(this.pagesCount - this.currentPageNumber < 5) {
                        return [this.pagesCount - 4, this.pagesCount - 3, this.pagesCount - 2, this.pagesCount - 1, this.pagesCount];
                    } else {
                        return [this.currentPageNumber - 2, this.currentPageNumber - 1, this.currentPageNumber, this.currentPageNumber + 1,  this.currentPageNumber + 2];
                    }
                }
            }
        },
        methods: {
            selectResultsPage(page_number) {
                this.$emit('page-changed', page_number);
            }
        }
    }
</script>
