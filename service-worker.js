/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js");

self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "404.html",
    "revision": "20f3543384d6ddc32f0560b09d81ea00"
  },
  {
    "url": "assets/css/0.styles.c09d2a25.css",
    "revision": "5c3c470e9888437e1bab39109be6997a"
  },
  {
    "url": "assets/img/copied.26408bed.svg",
    "revision": "26408bed185146a74d6fb7d71b4207e9"
  },
  {
    "url": "assets/img/copy.e3634ccf.svg",
    "revision": "e3634ccf2a60445e59d5f255481010fd"
  },
  {
    "url": "assets/js/10.8659956c.js",
    "revision": "29dc9268af4c5962b96132f220444b61"
  },
  {
    "url": "assets/js/11.5e177460.js",
    "revision": "e4761d07e17c66e27644decc9007fbd7"
  },
  {
    "url": "assets/js/12.2f9c2f74.js",
    "revision": "e04f8bafd49e274b6904faa92aaaafa2"
  },
  {
    "url": "assets/js/13.e5a300be.js",
    "revision": "ace9c3dda50bb5615ba76f86650832c5"
  },
  {
    "url": "assets/js/14.f9ad00d1.js",
    "revision": "bb170b3eaa3261dd925e2b61fed2a687"
  },
  {
    "url": "assets/js/15.ae4c8332.js",
    "revision": "cad505039883115c77beab347c22af51"
  },
  {
    "url": "assets/js/16.a34a9122.js",
    "revision": "4282c61b52bd28852460eb5440f6986d"
  },
  {
    "url": "assets/js/17.3534fbb7.js",
    "revision": "5a51a7d63c6e1539cc1beff5bac28cd2"
  },
  {
    "url": "assets/js/18.f96a8065.js",
    "revision": "b77d1906f38c3ae1d266b69f06af0136"
  },
  {
    "url": "assets/js/19.ec2fab0d.js",
    "revision": "b28615d42c3131978ba6efcf1e81648b"
  },
  {
    "url": "assets/js/2.79923db3.js",
    "revision": "9530ee1dcf801e928c7bf77d175a1040"
  },
  {
    "url": "assets/js/20.098902be.js",
    "revision": "1d3b90b89bfd95bf6ce5682fbbe30631"
  },
  {
    "url": "assets/js/21.e9bbcf02.js",
    "revision": "f10c39f8b3d3e9502e981969b0d6d1c2"
  },
  {
    "url": "assets/js/22.6ff5019b.js",
    "revision": "43c9c25346e988536d5efe17b2686f8b"
  },
  {
    "url": "assets/js/23.20baf87c.js",
    "revision": "b853c49c316755a866869b1e0b395a82"
  },
  {
    "url": "assets/js/3.6ff87e1d.js",
    "revision": "99b2240e067d3e5cbc4507a7bfd7634e"
  },
  {
    "url": "assets/js/4.577eab19.js",
    "revision": "6bb225b4f49513c4d3492cc1439a8cfb"
  },
  {
    "url": "assets/js/5.46768996.js",
    "revision": "e4fdb2faf283a84612dda2ca868aa299"
  },
  {
    "url": "assets/js/6.df576992.js",
    "revision": "b6eccbb2d89c1db828ba7cf68fab7517"
  },
  {
    "url": "assets/js/7.c273fc42.js",
    "revision": "7e4f84f9d7a32b559a582de3b6f217e7"
  },
  {
    "url": "assets/js/8.e8d5f0b7.js",
    "revision": "d497e2e1e1f115cee1d821a479e1dfde"
  },
  {
    "url": "assets/js/9.4f3ebce9.js",
    "revision": "e270bc5c002bed0a7ce7757c80895fe2"
  },
  {
    "url": "assets/js/app.3a232b9c.js",
    "revision": "3490148dc3ba94cca02469fa8fc51c3b"
  },
  {
    "url": "guide/context.html",
    "revision": "1a1df27d9f303675ace4bd7bfeacab19"
  },
  {
    "url": "guide/creating-pipelines.html",
    "revision": "41167988a57899c0f071f305c34ad868"
  },
  {
    "url": "guide/index.html",
    "revision": "450f2d7b2a87427976eb7e0d54b47598"
  },
  {
    "url": "guide/pipes.html",
    "revision": "bd69bca467d75db0463c8cbe598536c3"
  },
  {
    "url": "guide/practices.html",
    "revision": "8db09c729bcc755acf0d6dbc9ce4166e"
  },
  {
    "url": "icons/android-chrome-192x192.png",
    "revision": "8aaf07152270a717c4168a3903abfdce"
  },
  {
    "url": "icons/android-chrome-512x512.png",
    "revision": "b2ed2dc94a0472d66ab6d57159c4b0b4"
  },
  {
    "url": "icons/apple-touch-icon.png",
    "revision": "e6c94874ed2d2f37a4f5bdc4286027a5"
  },
  {
    "url": "icons/favicon-16x16.png",
    "revision": "45ab50e67975a6ae2767514d7c4782d4"
  },
  {
    "url": "icons/favicon-32x32.png",
    "revision": "622bd319b0172c0fe62cdbf881e44f34"
  },
  {
    "url": "index.html",
    "revision": "f65392bdb7ce0842325046355330fe96"
  },
  {
    "url": "installation.html",
    "revision": "9dfe2f8118ba608535708bc76b85b063"
  },
  {
    "url": "logo.png",
    "revision": "6739f04a1272da86a930f06501c0fe0f"
  },
  {
    "url": "operators.html",
    "revision": "593c1fa2cdb8444f727f1c7d9252cd75"
  },
  {
    "url": "rationale.html",
    "revision": "c420ee82059dbd230b390db90b078425"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});
addEventListener('message', event => {
  const replyPort = event.ports[0]
  const message = event.data
  if (replyPort && message && message.type === 'skip-waiting') {
    event.waitUntil(
      self.skipWaiting().then(
        () => replyPort.postMessage({ error: null }),
        error => replyPort.postMessage({ error })
      )
    )
  }
})
