<style scoped>
    .container {
        max-width: 960px;
        margin: 0 auto;
    }
</style>

<template>
    <div class="container">
        <el-row>
            <el-col :span="24">
                <h1>Welcome to the home page</h1>
                <el-alert v-if="!hasButtonBeenClicked" type="success">Try clicking the button below</el-alert>
                <p></p>
                <p v-if="hasButtonBeenClicked">
                    The button has been clicked <em>{{ this.clickCount }}</em> times.
                </p>
                <el-button @click="onClick" :disabled="isButtonDisabled">
                    {{ isButtonDisabled ? 'Hold on...' : 'Click me'}}</el-button>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        mounted() {
            //
        },

        data() {
            return {
                clickCount: 0,
                isButtonDisabled: false
            }
        },

        computed: {
            hasButtonBeenClicked() {
                return this.clickCount > 0;
            }
        },

        methods: {
            onClick() {
                const disableButton = () => this.isButtonDisabled = true;
                const enableButton = () => this.isButtonDisabled = false;
                const timeoutForTwoSeconds = () => new Promise(resolve => setTimeout(resolve, 2000));
                const incrementClick = () => this.clickCount++;

                return Promise.resolve()
                    .then(disableButton)
                    .then(timeoutForTwoSeconds)
                    .then(incrementClick)
                    .then(enableButton)
            }
        }
    }
</script>
