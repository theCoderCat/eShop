<template>
    <input type="text" class="form-control date">
</template>

<script>
    export default {
        props: ['options', 'value', 'startDate', 'endDate'],
        mounted() {
            let vm = this;
            $(this.$el)
                    .val(this.value)
                    // emit event on change.
                    .on('change', function () {
                        vm.$emit('input', this.value);
                    });
            if (this.options) {
                $(this.$el).datepicker(this.options);
            }
            if (this.startDate) {
                $(this.$el).datepicker('setStartDate', this.startDate);
            }
            if (this.endDate) {
                $(this.$el).endDate('setEndDate', this.endDate);
            }
        },
        watch: {
            value: function (value) {
                // update date
//                console.log(['value changed to: ', value]);
                $(this.$el).val(value);
//                $(this.$ele).datepicker('setDate', value);
            },
            options: function (options) {
                // update options
                $(this.$el).datepicker(options);
//                console.log('options changed');
            },
            startDate: function(startDate) {
//                console.log(['change start date: ', startDate]);
                $(this.$el).datepicker('setStartDate', startDate);
            },
            endDate: function(endDate) {
//                console.log(['change end date: ', endDate]);
                $(this.$el).datepicker('setEndDate', endDate);
            }
        },
        destroyed: function () {
            // destroy
        }
    }
</script>