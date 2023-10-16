<template>
    <div>
        <div class="spinnerContainer" v-if="isLoading && screen">
            <div class="arc"></div>
            <p class="text-danger" id="errorMessage">No Attachments</p>
        </div>
        <div v-if="!isStandardPresentationMode || screenHasOrders">
            <div
                class="bg"
                :style="{ backgroundImage: createBackgroundString }"
            ></div>
            <div
                class="bg bg2"
                :style="`background-image: linear-gradient(-60deg,  ${screen.color1} 50%, ${screen.color2} 50%);`"
            ></div>
            <div
                class="bg bg3"
                :style="`background-image: linear-gradient(-60deg,  ${screen.color1} 50%, ${screen.color2} 50%);`"
            ></div>
        </div>
        <div class="row no-gutters">
            <div
                :class="{
                    'col-md-8': screenHasOrders,
                    'col-md-12': !screenHasOrders,
                }"
            >
                <div
                    key="screen"
                    :class="{
                        standardPresentation: isStandardPresentationMode,
                        'theater-presentation':
                            !isStandardPresentationMode || screenHasOrders,
                        'col-md-8': screenHasOrders,
                    }"
                    v-if="!isLoading && screenHasAttachments"
                >
                    <div
                        v-if="screen.attachments[currentSlide].type === 'image'"
                        :key="screen.attachments[currentSlide]"
                    >
                        <img
                            :class="{
                                mediaContainer: isStandardPresentationMode,
                            }"
                            :src="
                                screen.attachments[currentSlide]
                                    ? screen.attachments[currentSlide].link
                                    : ''
                            "
                            alt=""
                        />
                    </div>
                    <div
                        v-if="screen.attachments[currentSlide].type === 'quote'"
                        :key="screen.attachments[currentSlide]"
                    >
                        <quote-component :data="screen.attachments[currentSlide]"></quote-component>
                    </div>
                    <div
                        v-if="screen.attachments[currentSlide].type === 'video'"
                        :key="screen.attachments[currentSlide]"
                    >
                        <video width="100%" autoplay id="backgroundvid">
                            <source
                                :src="
                                    screen.attachments[currentSlide]
                                        ? screen.attachments[currentSlide].link
                                        : ''
                                "
                                type="video/mp4"
                            />
                            <source src="mov_bbb.ogg" type="video/ogg" />
                            Your browser does not support HTML video.
                        </video>
                    </div>
                    <div
                        v-if="
                            screen.attachments[currentSlide].type === 'twitter'
                        "
                        :key="screen.attachments[currentSlide]"
                    >
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <img
                                        :src="
                                            screen.attachments[currentSlide]
                                                .tweetInfo.user.profileImage
                                        "
                                        alt=""
                                        style="height: 25%"
                                    />
                                </div>
                                <div class="col-md-7">
                                    <h1 class="px-4 d-inline">
                                        {{
                                            screen.attachments[currentSlide]
                                                .tweetInfo.user.user
                                        }}
                                    </h1>
                                    <p class="px-4">
                                        {{
                                            screen.attachments[currentSlide]
                                                .text
                                        }}
                                    </p>
                                    <div
                                        class="twitter-images"
                                        style="margin-top: -58% !important"
                                    >
                                        <img
                                            v-for="(imageLink, index) in screen
                                                .attachments[currentSlide]
                                                .tweetInfo.images"
                                            :key="index"
                                            :src="imageLink"
                                            alt=""
                                            class="img-fluid"
                                            style="height: 35vh"
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="d-flex justify-content-center">
                                
                                <div class="h-25">
                                    
                                </div>
                            </div>
                            <div class="d-flex">
                                
                            </div> -->
                        </div>
                    </div>
                    <div
                        v-if="
                            screen.attachments[currentSlide].type === 'youtube'
                        "
                        :key="currentSlide"
                    >
                        <youtube
                            :video-id="screen.attachments[currentSlide].smLink"
                            :player-vars="{ autoplay: 1 }"
                            @ended="nextSlide(true)"
                            ref="youtube"
                        ></youtube>
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-4" v-if="screen && screenHasOrders">
                <h1
                    class="
                        my-1
                        display-1
                        font-weight-bold
                        text-center text-white
                    "
                >
                    Orders
                </h1>
                <div class="row no-gutters mt-5">
                    <div
                        class="col-md-6"
                        v-for="(order, index) in screen.orders"
                        :key="index"
                    >
                        <div
                            :class="{
                                'order-card': true,
                                'order-serving': servingOrder(order),
                                'order-waiting': waitingOrder(order),
                                'mx-2': true,
                            }"
                        >
                            <h1
                                class="
                                    display-4
                                    py-5
                                    text-center text-white
                                    font-weight-bold
                                "
                            >
                                {{ order.number }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="messageBar"
            v-if="screen && (screen.hasMessageBar)"
        >
            <ul>
                <li v-for="message in screen.messages" :key="message.id">
                    {{ message.text }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import QuoteComponent from './QuoteComponent.vue';
export default {
    components:{
        QuoteComponent
    },
    props: ["id"],
    data() {
        return {
            isLoading: true,
            screen: null,
            currentSlide: 0,
            errorMessage: "",
        };
    },
    computed: {
        player() {
            return this.$refs.youtube.player;
        },
        isStandardPresentationMode() {
            return this.screen
                ? this.screen.presentationMode === "standard"
                : true;
        },
        screenHasOrders() {
            return this.screen.orders.length > 0;
        },
        screenHasAttachments() {
            return this.screen.attachments.length > 0;
        },
        createBackgroundString() {
            return `linear-gradient(-60deg, ${this.screen.color1}, ${this.screen.color2})`;
        },
    },
    mounted() {
        this.getData();

        const channel = Echo.channel(`screen-${this.id}-channel`);

        const eventsTolisten = [
            "AttachmentAttached",
            "AttachmentDetached",
            "ScreenUpdated",
            "MessageAttached",
            "MessageDetached",
            "OrderHasBeenServed",
            "OrderIsServing",
        ];

        eventsTolisten.forEach((event) => {
            channel.listen(event, (e) => {
                this.handleSocketEvents({
                    name: event,
                    data: e,
                });
            });
        });
    },
    methods: {
        getData: function () {
            axios.get(`/screen_resource/${this.id}`).then((response) => {
                this.screen = response.data;
                this.startShow();
                if (
                    this.screen.attachments.length > 0 ||
                    this.screen.orders.length > 0
                )
                    this.isLoading = false;
                else this.errorMessage = "no attachments";
            });
        },
        startShow: function () {
            try {
                var currentDuration = this.screen
                    ? this.screen.attachments[this.currentSlide].duration * 1000
                    : 0;
                setTimeout(this.nextSlide, currentDuration);
            } catch (e) {}
        },
        async playVideo() {
            this.player.playVideo();
            // Do something after the playVideo command
        },
        nextSlide: function (fromYoutube = false) {
            if (this.currentSlide < this.screen.attachments.length - 1) {
                this.currentSlide++;
            } else {
                this.currentSlide = 0;
            }
            if(this.currentSlide.type === 'video'){
                document.getElementById('backgroundvid').msRequestFullScreen();
            }
            this.startShow();
        },
        handleSocketEvents: function (event) {
            console.log(event);
            switch (event.name) {
                case "ScreenColorUpdated":
                    alert('color updated');
                    break;
                case "AttachmentAttached":
                    this.screen.attachments.push(event.data.attachment);
                    if (this.isLoading) this.isLoading = false;
                    if (event.data.attachment.type == "youtube") {
                        window.location.reload();
                    }
                    this.startShow();
                    break;
                case "AttachmentDetached":
                    var i = this.screen.attachments.findIndex(
                        (s) => s.id === event.data.attachment.id
                    );
                    this.screen.attachments.splice(i, 1);
                    this.startShow();
                    if (this.screen.attachments.length == 0) {
                        this.isLoading = true;
                        this.errorMessage = "no attachments";
                    }
                    break;
                case "ScreenUpdated":
                    this.screen.hasMessageBar = event.data.screen.hasMessageBar;
                    this.screen.presentationMode =
                        event.data.screen.presentationMode;
                    this.startShow();
                    break;
                case "MessageAttached":
                    this.screen.messages.push(event.data.message);
                    break;
                case "MessageDetached":
                    var i = this.screen.messages.findIndex(
                        (s) => s.id === event.data.message.id
                    );
                    this.screen.messages.splice(i, 1);
                    break;
                case "OrderHasBeenServed":
                    var orderIndex = this.screen.orders.findIndex(
                        (s) => s.number === event.data.order.number
                    );
                    this.screen.orders.splice(orderIndex, 1);
                    axios
                        .get(`/update-orders/${this.id}`)
                        .then((response) => {
                            this.screen.orders = response.data.data;
                        })
                        .catch((err) => {
                            alert(err);
                        });
                    break;
                case "OrderIsServing":
                    var orderIndex = this.screen.orders.findIndex(
                        (s) => s.number === event.data.order.number
                    );
                    this.screen.orders[orderIndex].status =
                        event.data.order.status;
                    break;
            }
        },
        servingOrder: function (order) {
            return order.status === "serving";
        },
        waitingOrder: function (order) {
            return order.status === "waiting";
        },
    },
};
</script>

<style scoped>
html,
body {
    margin: 0;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}
.standardPresentation * {
    width: 100%;
    height: 100vh;
}
.theater-presentation {
    top: 2%;
    right: 1%;
    left: 1%;
    position: fixed;
}
.theater-presentation * {
    width: 100%;
    height: 89vh;
}
:root {
    --dimension: 100px;
    --thickness: 4px;
    --color: red;
}

@keyframes rotate {
    to {
        transform: rotate(360deg);
    }
}

.spinnerContainer {
    display: grid;
    place-items: center;
    height: 100vh;
    z-index: 99999999999999999999999 !important;
}

.arc {
    position: relative;
    width: var(--dimension);
    height: var(--dimension);
}

.arc:before,
.arc:after {
    border-bottom: var(--thickness) solid var(--color);
    border-left: var(--thickness) solid transparent;
    border-radius: 50%;
    border-right: var(--thickness) solid var(--color);
    border-top: var(--thickness) solid var(--color);
    bottom: 0;
    box-sizing: border-box;
    content: "";
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    transform-origin: center center;
}

.arc:before {
    animation: rotate 1s ease-in-out infinite;
    height: 100%;
    width: 100%;
}

.arc:after {
    animation: rotate 1s ease-in-out infinite reverse;
    height: 50%;
    width: 50%;
}
.messageBar {
    width: 100%;
    height: 7vh;
    position: absolute;
    bottom: 0em !important;
    background: rgba(0, 0, 0, 0.3);
    overflow: hidden;
    padding-top: 0.5em;
}
.messageBar ul {
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    line-height: 50px;
    font-size: 30px;
    list-style: none;
    text-align: center;
    -moz-transform: translateX(100%);
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
    -moz-animation: scroll-left 20s linear infinite;
    -webkit-animation: scroll-left 20s linear infinite;
    animation: scroll-left 20s linear infinite;
}
.messageBar ul li {
    color: white;
    display: inline-block;
}
.messageBar ul li:before {
    content: "|";
    padding-left: 1em;
    padding-right: 1em;
}
.messageBar ul li:first-child:before {
    content: "";
    padding-left: 1em;
    padding-right: 1em;
}
.mediaContainer {
    -webkit-animation: fadein 2s; /* Safari, Chrome and Opera > 12.1 */
    -moz-animation: fadein 0.5s; /* Firefox < 16 */
    -ms-animation: fadein 0.5s; /* Internet Explorer */
    -o-animation: fadein 0.5s; /* Opera < 12.1 */
    animation: fadein 0.5s;
}
video#backgroundvid {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
}
.quote-container {
    position: absolute;
    width: 80%;
    height: 80vh;
    background: rgba(0, 0, 0, 0.3);
    top: 10%;
    left: 10%;
    text-align: center;
}
.q-text {
    position: absolute;
    top: 25%;
    color: white;
}
.bg {
    animation: slide 3s ease-in-out infinite alternate;
    bottom: 0;
    left: -50%;
    opacity: 0.5;
    position: fixed;
    right: -50%;
    top: 0;
    z-index: -1;
}

.twitter-images img {
    width: 50%;
    height: 25%;
}
.bg2 {
    animation-direction: alternate-reverse;
    animation-duration: 4s;
}

.bg3 {
    animation-duration: 5s;
}
#errorMessage {
    position: absolute;
    text-align: center;
    top: 60%;
    left: 50%;
    transform: translateX(-50%);
}
.order-card {
    border-radius: 2rem;
}
.order-serving {
    background: green;
}
.order-waiting {
    background: red;
}
@-moz-keyframes scroll-left {
    0% {
        -moz-transform: translateX(100%);
    }
    100% {
        -moz-transform: translateX(-100%);
    }
}

@-webkit-keyframes scroll-left {
    0% {
        -webkit-transform: translateX(100%);
    }
    100% {
        -webkit-transform: translateX(-100%);
    }
}

@keyframes scroll-left {
    0% {
        -moz-transform: translateX(100%);
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
    }
    100% {
        -moz-transform: translateX(-100%);
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
    }
}
@keyframes fadein {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
@keyframes slide {
    0% {
        transform: translateX(-25%);
    }
    100% {
        transform: translateX(25%);
    }
}
/* Firefox < 16 */
@-moz-keyframes fadein {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Safari, Chrome and Opera > 12.1 */
@-webkit-keyframes fadein {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Internet Explorer */
@-ms-keyframes fadein {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
