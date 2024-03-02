<div class="d-inline-flex flex-row align-items-center" x-key="$wire.userRate" x-data="{
    userUser() {
            return this.$wire.userRate;
        },
        rateRound() {
            return Math.round(this.userUser());
        },
        currentRate: 0,
        hoverIcon: false,
        getClassIcon(_rate) {
            if (this.hoverIcon && this.currentRate !== this.userUser()) {
                if (_rate <= this.currentRate) {
                    return this.ratedIcon;
                }
                return this.unRatedIcon;
            }
            if (_rate <= this.rateRound()) {
                return this.ratedIcon;
            } else if (_rate <= this.rateRound() + 0.5) {
                return this.halfRatedIcon;
            } else {
                return this.unRatedIcon;
            }
        }
}"
    x-init="currentRate = userUser()" @mouseleave="currentRate = this.userUser(); hoverIcon = false;">
    <div class="me-3 flex flex-row text-center">
        <template x-for="i in $wire.rateMax">
            <i :class="getClassIcon(i)" @mouseover="currentRate = i; hoverIcon = true;" @click="chooseRate(i);"></i>
        </template>
        <div class="d-inline-flex" style="width: 20px" x-text="currentRate" x-transition></div>
    </div>
</div>
