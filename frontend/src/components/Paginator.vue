<script>
  export default {
    data() {
      return {page: 1, meta: {}, linksToShow: 10}
    },
    props: {
      paginator: {type: Function, required: true}
    },
    computed: {
      pages() {
        let pages = [];

        if (this.meta.pages.total) {
          const startPage = Math.max(1, this.page - Math.floor(this.linksToShow / 2));
          const endPage = Math.min(this.meta.pages.total, startPage + this.linksToShow - 1);

          return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
        }

        return pages;
      }
    },
    methods: {
      goTo(targetPage) {
        this.paginator(targetPage)
          .then(r => {
            this.page = targetPage;
            this.meta = r.meta;

            return r;
          })
      },
    },
    mounted() {
      this.$nextTick(() => {
        this.goTo(this.page)
      })
    }
  }
</script>

<template>
  <nav aria-label="Paginate records" v-if="typeof this.meta.pages !== 'undefined'">
    <ul class="pagination">
      <li v-if="this.meta.pages.total" class="page-item">
        <button :disabled="this.page === 1" class="page-link" @click.prevent="goTo(1)">First</button>
      </li>
      <li v-if="this.meta.pages.prev" class="page-item">
        <button class="page-link" @click.prevent="goTo(this.meta.pages.prev)">Prev</button>
      </li>

      <li v-for="page in pages" class="page-item">
        <button :disabled="this.page === page" class="page-link" @click.prevent="goTo(page)">{{page}}</button>
      </li>

      <li v-if="this.meta.pages.next" class="page-item">
        <button class="page-link" @click.prevent="goTo(this.meta.pages.next)">Next</button>
      </li>
      <li v-if="this.meta.pages.total" class="page-item">
        <button :disabled="this.page === this.meta.pages.total" class="page-link" @click.prevent="goTo(this.meta.pages.total)">Last</button>
      </li>
    </ul>
  </nav>
</template>
