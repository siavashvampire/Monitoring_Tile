/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.0.6 (2019-05-22)
 */
! function(l) {
    "use strict";
    var e, n, r, t, a, i = tinymce.util.Tools.resolve("tinymce.PluginManager"),
        o = function(e, n) {
            return e.fire("insertCustomChar", {
                chr: n
            })
        },
        f = function(e, n) {
            var r = o(e, n).chr;
            e.execCommand("mceInsertContent", !1, r)
        },
        c = tinymce.util.Tools.resolve("tinymce.util.Tools"),
        u = function(e) {
            return e.settings.erfanPlugin1
        },
        s = function(e) {
            return e.settings.erfanPlugin1_append
        },
        g = function(e) {
            return function() {
                return e
            }
        },
        m = g(!1),
        h = g(!0),
        d = m,
        p = h,
        y = function() {
            return w
        },
        w = (t = {
            fold: function(e, n) {
                return e()
            },
            is: d,
            isSome: d,
            isNone: p,
            getOr: r = function(e) {
                return e
            },
            getOrThunk: n = function(e) {
                return e()
            },
            getOrDie: function(e) {
                throw new Error(e || "error: getOrDie called on none.")
            },
            getOrNull: function() {
                return null
            },
            getOrUndefined: function() {
                return undefined
            },
            or: r,
            orThunk: n,
            map: y,
            ap: y,
            each: function() {},
            bind: y,
            flatten: y,
            exists: d,
            forall: p,
            filter: y,
            equals: e = function(e) {
                return e.isNone()
            },
            equals_: e,
            toArray: function() {
                return []
            },
            toString: g("none()")
        }, Object.freeze && Object.freeze(t), t),
        b = function(r) {
            var e = function() {
                    return r
                },
                n = function() {
                    return a
                },
                t = function(e) {
                    return e(r)
                },
                a = {
                    fold: function(e, n) {
                        return n(r)
                    },
                    is: function(e) {
                        return r === e
                    },
                    isSome: p,
                    isNone: d,
                    getOr: e,
                    getOrThunk: e,
                    getOrDie: e,
                    getOrNull: e,
                    getOrUndefined: e,
                    or: n,
                    orThunk: n,
                    map: function(e) {
                        return b(e(r))
                    },
                    ap: function(e) {
                        return e.fold(y, function(e) {
                            return b(e(r))
                        })
                    },
                    each: function(e) {
                        e(r)
                    },
                    bind: t,
                    flatten: e,
                    exists: t,
                    forall: t,
                    filter: function(e) {
                        return e(r) ? a : w
                    },
                    equals: function(e) {
                        return e.is(r)
                    },
                    equals_: function(e, n) {
                        return e.fold(d, function(e) {
                            return n(r, e)
                        })
                    },
                    toArray: function() {
                        return [r]
                    },
                    toString: function() {
                        return "some(" + r + ")"
                    }
                };
            return a
        },
        v = {
            some: b,
            none: y,
            from: function(e) {
                return null === e || e === undefined ? w : b(e)
            }
        },
        k = (a = "function", function(e) {
            return function(e) {
                if (null === e) return "null";
                var n = typeof e;
                return "object" === n && Array.prototype.isPrototypeOf(e) ? "array" : "object" === n && String.prototype.isPrototypeOf(e) ? "string" : n
            }(e) === a
        }),
        C = function(e, n) {
            for (var r = e.length, t = new Array(r), a = 0; a < r; a++) {
                var i = e[a];
                t[a] = n(i, a, e)
            }
            return t
        },
        A = Array.prototype.push,
        O = function(e, n) {
            return function(e) {
                for (var n = [], r = 0, t = e.length; r < t; ++r) {
                    if (!Array.prototype.isPrototypeOf(e[r])) throw new Error("Arr.flatten item " + r + " was not an array, input: " + e);
                    A.apply(n, e[r])
                }
                return n
            }(C(e, n))
        },
        x = (Array.prototype.slice, k(Array.from) && Array.from, c.isArray),
        q = "User Defined",
        S = function(e) {
            return x(e) ? [].concat((n = e, c.grep(n, function(e) {
                return x(e) && 2 === e.length
            }))) : "function" == typeof e ? e() : [];
            var n
        },
        T = function(e) {
            var n = function(e, n) {
                var r = u(e);
                r && (n = [{
                    name: q,
                    characters: S(r)
                }]);
                var t = s(e);
                if (t) {
                    var a = c.grep(n, function(e) {
                        return e.name === q
                    });
                    return a.length ? (a[0].characters = [].concat(a[0].characters).concat(S(t)), n) : [].concat(n).concat({
                        name: q,
                        characters: S(t)
                    })
                }
                return n
            }(e, [{
                name: "Currency",
                characters: [
                    [36, "dollar sign"],
                    [162, "cent sign"],
                    [8364, "euro sign"],
                    [163, "pound sign"],
                    [165, "yen sign"],
                    [164, "currency sign"],
                    [8352, "euro-currency sign"],
                    [8353, "colon sign"],
                    [8354, "cruzeiro sign"],
                    [8355, "french franc sign"],
                    [8356, "lira sign"],
                    [8357, "mill sign"],
                    [8358, "naira sign"],
                    [8359, "peseta sign"],
                    [8360, "rupee sign"],
                    [8361, "won sign"],
                    [8362, "new sheqel sign"],
                    [8363, "dong sign"],
                    [8365, "kip sign"],
                    [8366, "tugrik sign"],
                    [8367, "drachma sign"],
                    [8368, "german penny symbol"],
                    [8369, "peso sign"],
                    [8370, "guarani sign"],
                    [8371, "austral sign"],
                    [8372, "hryvnia sign"],
                    [8373, "cedi sign"],
                    [8374, "livre tournois sign"],
                    [8375, "spesmilo sign"],
                    [8376, "tenge sign"],
                    [8377, "indian rupee sign"],
                    [8378, "turkish lira sign"],
                    [8379, "nordic mark sign"],
                    [8380, "manat sign"],
                    [8381, "ruble sign"],
                    [20870, "yen character"],
                    [20803, "yuan character"],
                    [22291, "yuan character, in hong kong and taiwan"],
                    [22278, "yen/yuan character variant one"]
                ]
            }, {
                name: "Text",
                characters: [
                    [169, "copyright sign"],
                    [174, "registered sign"],
                    [8482, "trade mark sign"],
                    [8240, "per mille sign"],
                    [181, "micro sign"],
                    [183, "middle dot"],
                    [8226, "bullet"],
                    [8230, "three dot leader"],
                    [8242, "minutes / feet"],
                    [8243, "seconds / inches"],
                    [167, "section sign"],
                    [182, "paragraph sign"],
                    [223, "sharp s / ess-zed"]
                ]
            }, {
                name: "Quotations",
                characters: [
                    [8249, "single left-pointing angle quotation mark"],
                    [8250, "single right-pointing angle quotation mark"],
                    [171, "left pointing guillemet"],
                    [187, "right pointing guillemet"],
                    [8216, "left single quotation mark"],
                    [8217, "right single quotation mark"],
                    [8220, "left double quotation mark"],
                    [8221, "right double quotation mark"],
                    [8218, "single low-9 quotation mark"],
                    [8222, "double low-9 quotation mark"],
                    [60, "less-than sign"],
                    [62, "greater-than sign"],
                    [8804, "less-than or equal to"],
                    [8805, "greater-than or equal to"],
                    [8211, "en dash"],
                    [8212, "em dash"],
                    [175, "macron"],
                    [8254, "overline"],
                    [164, "currency sign"],
                    [166, "broken bar"],
                    [168, "diaeresis"],
                    [161, "inverted exclamation mark"],
                    [191, "turned question mark"],
                    [710, "circumflex accent"],
                    [732, "small tilde"],
                    [176, "degree sign"],
                    [8722, "minus sign"],
                    [177, "plus-minus sign"],
                    [247, "division sign"],
                    [8260, "fraction slash"],
                    [215, "multiplication sign"],
                    [185, "superscript one"],
                    [178, "superscript two"],
                    [179, "superscript three"],
                    [188, "fraction one quarter"],
                    [189, "fraction one half"],
                    [190, "fraction three quarters"]
                ]
            }, {
                name: "Mathematical",
                characters: [
                    [402, "function / florin"],
                    [8747, "integral"],
                    [8721, "n-ary sumation"],
                    [8734, "infinity"],
                    [8730, "square root"],
                    [8764, "similar to"],
                    [8773, "approximately equal to"],
                    [8776, "almost equal to"],
                    [8800, "not equal to"],
                    [8801, "identical to"],
                    [8712, "element of"],
                    [8713, "not an element of"],
                    [8715, "contains as member"],
                    [8719, "n-ary product"],
                    [8743, "logical and"],
                    [8744, "logical or"],
                    [172, "not sign"],
                    [8745, "intersection"],
                    [8746, "union"],
                    [8706, "partial differential"],
                    [8704, "for all"],
                    [8707, "there exists"],
                    [8709, "diameter"],
                    [8711, "backward difference"],
                    [8727, "asterisk operator"],
                    [8733, "proportional to"],
                    [8736, "angle"]
                ]
            }, {
                name: "Extended Latin",
                characters: [
                    [192, "A - grave"],
                    [193, "A - acute"],
                    [194, "A - circumflex"],
                    [195, "A - tilde"],
                    [196, "A - diaeresis"],
                    [197, "A - ring above"],
                    [256, "A - macron"],
                    [198, "ligature AE"],
                    [199, "C - cedilla"],
                    [200, "E - grave"],
                    [201, "E - acute"],
                    [202, "E - circumflex"],
                    [203, "E - diaeresis"],
                    [274, "E - macron"],
                    [204, "I - grave"],
                    [205, "I - acute"],
                    [206, "I - circumflex"],
                    [207, "I - diaeresis"],
                    [298, "I - macron"],
                    [208, "ETH"],
                    [209, "N - tilde"],
                    [210, "O - grave"],
                    [211, "O - acute"],
                    [212, "O - circumflex"],
                    [213, "O - tilde"],
                    [214, "O - diaeresis"],
                    [216, "O - slash"],
                    [332, "O - macron"],
                    [338, "ligature OE"],
                    [352, "S - caron"],
                    [217, "U - grave"],
                    [218, "U - acute"],
                    [219, "U - circumflex"],
                    [220, "U - diaeresis"],
                    [362, "U - macron"],
                    [221, "Y - acute"],
                    [376, "Y - diaeresis"],
                    [562, "Y - macron"],
                    [222, "THORN"],
                    [224, "a - grave"],
                    [225, "a - acute"],
                    [226, "a - circumflex"],
                    [227, "a - tilde"],
                    [228, "a - diaeresis"],
                    [229, "a - ring above"],
                    [257, "a - macron"],
                    [230, "ligature ae"],
                    [231, "c - cedilla"],
                    [232, "e - grave"],
                    [233, "e - acute"],
                    [234, "e - circumflex"],
                    [235, "e - diaeresis"],
                    [275, "e - macron"],
                    [236, "i - grave"],
                    [237, "i - acute"],
                    [238, "i - circumflex"],
                    [239, "i - diaeresis"],
                    [299, "i - macron"],
                    [240, "eth"],
                    [241, "n - tilde"],
                    [242, "o - grave"],
                    [243, "o - acute"],
                    [244, "o - circumflex"],
                    [245, "o - tilde"],
                    [246, "o - diaeresis"],
                    [248, "o slash"],
                    [333, "o macron"],
                    [339, "ligature oe"],
                    [353, "s - caron"],
                    [249, "u - grave"],
                    [250, "u - acute"],
                    [251, "u - circumflex"],
                    [252, "u - diaeresis"],
                    [363, "u - macron"],
                    [253, "y - acute"],
                    [254, "thorn"],
                    [255, "y - diaeresis"],
                    [563, "y - macron"],
                    [913, "Alpha"],
                    [914, "Beta"],
                    [915, "Gamma"],
                    [916, "Delta"],
                    [917, "Epsilon"],
                    [918, "Zeta"],
                    [919, "Eta"],
                    [920, "Theta"],
                    [921, "Iota"],
                    [922, "Kappa"],
                    [923, "Lambda"],
                    [924, "Mu"],
                    [925, "Nu"],
                    [926, "Xi"],
                    [927, "Omicron"],
                    [928, "Pi"],
                    [929, "Rho"],
                    [931, "Sigma"],
                    [932, "Tau"],
                    [933, "Upsilon"],
                    [934, "Phi"],
                    [935, "Chi"],
                    [936, "Psi"],
                    [937, "Omega"],
                    [945, "alpha"],
                    [946, "beta"],
                    [947, "gamma"],
                    [948, "delta"],
                    [949, "epsilon"],
                    [950, "zeta"],
                    [951, "eta"],
                    [952, "theta"],
                    [953, "iota"],
                    [954, "kappa"],
                    [955, "lambda"],
                    [956, "mu"],
                    [957, "nu"],
                    [958, "xi"],
                    [959, "omicron"],
                    [960, "pi"],
                    [961, "rho"],
                    [962, "final sigma"],
                    [963, "sigma"],
                    [964, "tau"],
                    [965, "upsilon"],
                    [966, "phi"],
                    [967, "chi"],
                    [968, "psi"],
                    [969, "omega"]
                ]
            }, {
                name: "Symbols",
                characters: [
                    [8501, "alef symbol"],
                    [982, "pi symbol"],
                    [8476, "real part symbol"],
                    [978, "upsilon - hook symbol"],
                    [8472, "Weierstrass p"],
                    [8465, "imaginary part"]
                ]
            }, {
                name: "Arrows",
                characters: [
                    [8592, "leftwards arrow"],
                    [8593, "upwards arrow"],
                    [8594, "rightwards arrow"],
                    [8595, "downwards arrow"],
                    [8596, "left right arrow"],
                    [8629, "carriage return"],
                    [8656, "leftwards double arrow"],
                    [8657, "upwards double arrow"],
                    [8658, "rightwards double arrow"],
                    [8659, "downwards double arrow"],
                    [8660, "left right double arrow"],
                    [8756, "therefore"],
                    [8834, "subset of"],
                    [8835, "superset of"],
                    [8836, "not a subset of"],
                    [8838, "subset of or equal to"],
                    [8839, "superset of or equal to"],
                    [8853, "circled plus"],
                    [8855, "circled times"],
                    [8869, "perpendicular"],
                    [8901, "dot operator"],
                    [8968, "left ceiling"],
                    [8969, "right ceiling"],
                    [8970, "left floor"],
                    [8971, "right floor"],
                    [9001, "left-pointing angle bracket"],
                    [9002, "right-pointing angle bracket"],
                    [9674, "lozenge"],
                    [9824, "black spade suit"],
                    [9827, "black club suit"],
                    [9829, "black heart suit"],
                    [9830, "black diamond suit"],
                    [8194, "en space"],
                    [8195, "em space"],
                    [8201, "thin space"],
                    [8204, "zero width non-joiner"],
                    [8205, "zero width joiner"],
                    [8206, "left-to-right mark"],
                    [8207, "right-to-left mark"]
                ]
            }]);
            return 1 < n.length ? [{
                name: "All",
                characters: O(n, function(e) {
                    return e.characters
                })
            }].concat(n) : n
        },
        E = function(n) {
            return {
                geterfanPlugin1: function() {
                    return T(n)
                },
                insertChar: function(e) {
                    f(n, e)
                }
            }
        },
        z = function(e) {
            var n = e,
                r = function() {
                    return n
                };
            return {
                get: r,
                set: function(e) {
                    n = e
                },
                clone: function() {
                    return z(r())
                }
            }
        },
        U = function(e, n) {
            return -1 !== e.indexOf(n)
        },
        D = function(e, n) {
            var a = [],
                i = n.toLowerCase();
            return function(e, n) {
                for (var r = 0, t = e.length; r < t; r++) n(e[r], r, e)
            }(e.characters, function(e) {
                var n, r, t;
                n = e[0], r = e[0], t = i, (U(String.fromCharCode(n).toLowerCase(), t) || U(r.toLowerCase(), t) || U(r.toLowerCase().replace(/\s+/g, ""), t)) && a.push(e)
            }), C(a, function(e) {
                return {
                    text: e[0],
                    value: e[1],
                    icon: e[0]
                }
            })
        },
        I = "pattern",
        N = function(r, e) {
            var t, a, i, n = function() {
                    return [{
                        label: "Search",
                        type: "input",
                        name: I
                    }, {
                        type: "collection",
                        name: "results"
                    }]
                },
                o = 1 === e.length ? z(q) : z("All"),
                c = function(r, t) {
                    (function(e, n) {
                        for (var r = 0, t = e.length; r < t; r++) {
                            var a = e[r];
                            if (n(a, r, e)) return v.some(a)
                        }
                        return v.none()
                    })(e, function(e) {
                        return e.name === o.get()
                    }).each(function(e) {
                        var n = D(e, t);
                        r.setData({
                            results: n
                        })
                    })
                },
                u = (t = function(e) {
                    var n = e.getData().pattern;
                    c(e, n)
                }, a = 40, i = null, {
                    cancel: function() {
                        null !== i && (l.clearTimeout(i), i = null)
                    },
                    throttle: function() {
                        for (var e = [], n = 0; n < arguments.length; n++) e[n] = arguments[n];
                        null !== i && l.clearTimeout(i), i = l.setTimeout(function() {
                            t.apply(null, e), i = null
                        }, a)
                    }
                }),
                s = {
                    title: "???????? ?????? ?????????? ???? ???????? ??????",
                    size: "big",
                    body: 1 === e.length ? {
                        type: "panel",
                        items: n()
                    } : {
                        type: "tabpanel",
                        tabs: C(e, function(e) {
                            return {
                                title: e.name,
                                items: n()
                            }
                        })
                    },
                    buttons: [{
                        type: "cancel",
                        name: "close",
                        text: "Close",
                        primary: !0
                    }],
                    initialData: {
                        pattern: "",
                        results: D(e[0], "")
                    },
                    onAction: function(e, n) {
                        "results" === n.name && (f(r, n.value), e.close())
                    },
                    onTabChange: function(e, n) {
                        o.set(n), u.throttle(e)
                    },
                    onChange: function(e, n) {
                        n.name === I && u.throttle(e)
                    }
                };
            r.windowManager.open(s)
        },
        P = function(e, n) {
            e.addCommand("mceShowerfanPlugin1", function() {
                N(e, n)
            })
        },
        j = tinymce.util.Tools.resolve("tinymce.util.Promise"),
        L = function(e) {
            e.ui.registry.addButton("erfanPlugin1", {
                icon: "code-sample",
                text: '???????? ?????? ?????????? ???? ???????? ??????',
                tooltip: "Special character",
                onAction: function() {
                    return e.execCommand("mceShowerfanPlugin1")
                }
            }), e.ui.registry.addMenuItem("erfanPlugin1", {
                icon: "code-sample",
                text: "???????? ?????? ?????????? ???? ???????? ??????",
                onAction: function() {
                    return e.execCommand("mceShowerfanPlugin1")
                }
            })
        };
    i.add("erfanPlugin1", function(e) {
        var t, a, n = T(e);
        return P(e, n), L(e), t = e, a = n[0], t.ui.registry.addAutocompleter("erfanPlugin1", {
            ch: ":",
            columns: "auto",
            minChars: 2,
            fetch: function(r, e) {
                return new j(function(e, n) {
                    e(D(a, r))
                })
            },
            onAction: function(e, n, r) {
                t.selection.setRng(n), t.insertContent(r), e.hide()
            }
        }), E(e)
    }),
        function M() {}
}(window);