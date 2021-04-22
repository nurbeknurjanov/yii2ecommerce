<template>
    <div id="orderProductsGrid" class="grid-view" style="display: none">
        <table class="table table-striped table-bordered">
            <tbody>
            <tr v-for="(orderProduct, key, index) in orderProducts"  :data-key="key" >
                <td>
                    <input type="text"
                           class="count form-control"
                           :name="'OrderProduct['+key+'][price]'"
                           style="max-width:80px"
                           :value="orderProduct.price"
                    >
                    <input type="text"
                           class="count form-control"
                           :name="'OrderProduct['+key+'][count]'"
                           style="max-width:80px"
                           :value="orderProduct.count"
                    >
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['orderProducts'],
    }
</script>