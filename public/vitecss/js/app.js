// ============================================
// NUMBER UTILITIES
// ============================================

/**
 * RandomBetween - Returns random integer between min and max (inclusive)
 * @param {number} min - Minimum value
 * @param {number} max - Maximum value
 * @returns {number} Random integer
 * @example RandomBetween(1, 10) // 7
 */
function RandomBetween(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 * RandomFloat - Returns random float between min and max
 * @param {number} min - Minimum value
 * @param {number} max - Maximum value
 * @returns {number} Random float
 * @example RandomFloat(1.5, 5.5) // 3.78
 */
function RandomFloat(min, max) {
    return Math.random() * (max - min) + min;
}

/**
 * ClampNumber - Restricts number within min/max range
 * @param {number} value - Value to clamp
 * @param {number} min - Lower bound
 * @param {number} max - Upper bound
 * @returns {number} Clamped value
 * @example ClampNumber(15, 1, 10) // 10
 */
function ClampNumber(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

/**
 * ToCurrency - Formats number as currency
 * @param {number} value - Number to format
 * @param {string} locale - Locale (default: 'en-US')
 * @param {string} currency - Currency code (default: 'USD')
 * @returns {string} Formatted currency
 * @example ToCurrency(1234.56) // '$1,234.56'
 */
function ToCurrency(value, locale = 'en-US', currency = 'USD') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency
    }).format(value);
}

/**
 * ToPercentage - Converts number to percentage
 * @param {number} value - Number to convert
 * @param {number} decimals - Decimal places (default: 2)
 * @returns {string} Percentage string
 * @example ToPercentage(0.1234) // '12.34%'
 */
function ToPercentage(value, decimals = 2) {
    return (value * 100).toFixed(decimals) + '%';
}

// ============================================
// TYPE CHECKING - IS METHODS
// ============================================

/**
 * IsString - Checks if value is a string
 * @example IsString('hello') // true
 */
function IsString(value) {
    return typeof value === 'string' || value instanceof String;
}

/**
 * IsNumber - Checks if value is a number (not NaN)
 * @example IsNumber(42) // true
 */
function IsNumber(value) {
    return typeof value === 'number' && !isNaN(value);
}

/**
 * IsBoolean - Checks if value is boolean
 * @example IsBoolean(true) // true
 */
function IsBoolean(value) {
    return typeof value === 'boolean' || value instanceof Boolean;
}

/**
 * IsArray - Checks if value is an array
 * @example IsArray([1,2,3]) // true
 */
function IsArray(value) {
    return Array.isArray(value);
}

/**
 * IsObject - Checks if value is a plain object (not null, array, or function)
 * @example IsObject({a:1}) // true
 */
function IsObject(value) {
    return value !== null && typeof value === 'object' && !Array.isArray(value);
}

/**
 * IsFunction - Checks if value is a function
 * @example IsFunction(() => {}) // true
 */
function IsFunction(value) {
    return typeof value === 'function';
}

/**
 * IsNull - Checks if value is null
 * @example IsNull(null) // true
 */
function IsNull(value) {
    return value === null;
}

/**
 * IsUndefined - Checks if value is undefined
 * @example IsUndefined(undefined) // true
 */
function IsUndefined(value) {
    return value === undefined;
}

/**
 * IsEmpty - Checks if value is empty (null, undefined, '', [], {})
 * @example IsEmpty([]) // true
 */
function IsEmpty(value) {
    if (value === null || value === undefined) return true;
    if (typeof value === 'string') return value.length === 0;
    if (Array.isArray(value)) return value.length === 0;
    if (typeof value === 'object') return Object.keys(value).length === 0;
    return false;
}

/**
 * IsEmail - Validates email format
 * @example IsEmail('test@test.com') // true
 */
function IsEmail(value) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return IsString(value) && regex.test(value);
}

/**
 * IsURL - Validates URL format
 * @example IsURL('https://example.com') // true
 */
function IsURL(value) {
    try {
        new URL(value);
        return true;
    } catch {
        return false;
    }
}

/**
 * IsPhone - Validates phone number (US format)
 * @example IsPhone('123-456-7890') // true
 */
function IsPhone(value) {
    const regex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    return IsString(value) && regex.test(value);
}

/**
 * IsDate - Checks if value is valid date
 * @example IsDate('2026-07-02') // true
 */
function IsDate(value) {
    return !isNaN(new Date(value).getTime());
}

/**
 * IsInteger - Checks if value is integer
 * @example IsInteger(42) // true
 */
function IsInteger(value) {
    return Number.isInteger(value);
}

/**
 * IsFloat - Checks if value is float
 * @example IsFloat(3.14) // true
 */
function IsFloat(value) {
    return IsNumber(value) && !Number.isInteger(value);
}

/**
 * IsEven - Checks if number is even
 * @example IsEven(4) // true
 */
function IsEven(value) {
    return IsNumber(value) && value % 2 === 0;
}

/**
 * IsOdd - Checks if number is odd
 * @example IsOdd(5) // true
 */
function IsOdd(value) {
    return IsNumber(value) && value % 2 !== 0;
}

/**
 * IsPrime - Checks if number is prime
 * @example IsPrime(7) // true
 */
function IsPrime(value) {
    if (!IsNumber(value) || value < 2) return false;
    for (let i = 2; i <= Math.sqrt(value); i++) {
        if (value % i === 0) return false;
    }
    return true;
}

/**
 * IsPalindrome - Checks if string is palindrome
 * @example IsPalindrome('racecar') // true
 */
function IsPalindrome(value) {
    if (!IsString(value)) return false;
    const cleaned = value.toLowerCase().replace(/[^a-z0-9]/g, '');
    return cleaned === cleaned.split('').reverse().join('');
}

// ============================================
// ARRAY UTILITIES
// ============================================

/**
 * FilterArray - Generic array filter with custom condition
 * @example FilterArray([1,2,3,4,5], n => n > 3) // [4,5]
 */
function FilterArray(arr, condition) {
    const result = [];
    for (let i = 0; i < arr.length; i++) {
        if (condition(arr[i], i, arr)) {
            result.push(arr[i]);
        }
    }
    return result;
}

/**
 * FilterUnique - Removes duplicate values from array
 * @example FilterUnique([1,2,2,3,3,4]) // [1,2,3,4]
 */
function FilterUnique(arr) {
    return [...new Set(arr)];
}

/**
 * FilterFalsy - Removes falsy values (null, undefined, false, 0, '', NaN)
 * @example FilterFalsy([0,1,false,2,'',3]) // [1,2,3]
 */
function FilterFalsy(arr) {
    return FilterArray(arr, item => !!item);
}

/**
 * FilterByProperty - Filters objects by matching property value
 * @example FilterByProperty(users, 'age', 25)
 */
function FilterByProperty(arr, key, value) {
    return FilterArray(arr, item => item[key] === value);
}

/**
 * FilterByProperties - Filters objects matching multiple property values
 * @example FilterByProperties(users, { age:25, active:true })
 */
function FilterByProperties(arr, filters) {
    return FilterArray(arr, item => {
        for (const key in filters) {
            if (item[key] !== filters[key]) return false;
        }
        return true;
    });
}

/**
 * GroupBy - Groups array items by key
 * @example GroupBy(users, 'age') // {25: [...], 30: [...]}
 */
function GroupBy(arr, key) {
    const result = {};
    for (const item of arr) {
        const groupKey = item[key];
        if (!result[groupKey]) result[groupKey] = [];
        result[groupKey].push(item);
    }
    return result;
}

/**
 * SortBy - Sorts array by property or custom function
 * @example SortBy(users, 'age', 'desc')
 */
function SortBy(arr, key, order = 'asc') {
    const result = [...arr];
    result.sort((a, b) => {
        const aVal = typeof key === 'function' ? key(a) : a[key];
        const bVal = typeof key === 'function' ? key(b) : b[key];
        if (aVal < bVal) return order === 'asc' ? -1 : 1;
        if (aVal > bVal) return order === 'asc' ? 1 : -1;
        return 0;
    });
    return result;
}

/**
 * Pluck - Extracts array of property values from objects
 * @example Pluck(users, 'name') // ['Alice', 'Bob']
 */
function Pluck(arr, key) {
    return arr.map(item => item[key]);
}

/**
 * Intersection - Returns common elements between arrays
 * @example Intersection([1,2,3], [2,3,4]) // [2,3]
 */
function Intersection(arr1, arr2) {
    const set = new Set(arr2);
    return arr1.filter(item => set.has(item));
}

/**
 * Difference - Returns elements in arr1 not in arr2
 * @example Difference([1,2,3], [2,3,4]) // [1]
 */
function Difference(arr1, arr2) {
    const set = new Set(arr2);
    return arr1.filter(item => !set.has(item));
}

/**
 * Union - Returns unique elements from multiple arrays
 * @example Union([1,2], [2,3], [3,4]) // [1,2,3,4]
 */
function Union(...arrays) {
    return [...new Set(arrays.flat())];
}

/**
 * ShuffleArray - Randomly shuffles array (Fisher-Yates algorithm)
 * @example ShuffleArray([1,2,3,4,5]) // [3,1,5,2,4]
 */
function ShuffleArray(arr) {
    const result = [...arr];
    for (let i = result.length - 1; i > 0; i--) {
        const j = RandomBetween(0, i);
        [result[i], result[j]] = [result[j], result[i]];
    }
    return result;
}

/**
 * RandomPick - Returns random item from array
 * @example RandomPick(['apple','banana','cherry']) // 'banana'
 */
function RandomPick(arr) {
    return arr[RandomBetween(0, arr.length - 1)];
}

/**
 * ChunkArray - Splits array into smaller arrays of given size
 * @example ChunkArray([1,2,3,4,5,6], 2) // [[1,2],[3,4],[5,6]]
 */
function ChunkArray(arr, size) {
    const result = [];
    for (let i = 0; i < arr.length; i += size) {
        result.push(arr.slice(i, i + size));
    }
    return result;
}

/**
 * Flatten - Flattens nested arrays to specified depth
 * @example Flatten([1,[2,[3,4]]], 1) // [1,2,[3,4]]
 */
function Flatten(arr, depth = 1) {
    return arr.flat(depth);
}

/**
 * Zip - Combines multiple arrays into array of tuples
 * @example Zip([1,2], ['a','b']) // [[1,'a'],[2,'b']]
 */
function Zip(...arrays) {
    const maxLength = Math.max(...arrays.map(arr => arr.length));
    const result = [];
    for (let i = 0; i < maxLength; i++) {
        result.push(arrays.map(arr => arr[i]));
    }
    return result;
}

/**
 * Unzip - Splits array of tuples into multiple arrays
 * @example Unzip([[1,'a'],[2,'b']]) // [[1,2], ['a','b']]
 */
function Unzip(arr) {
    return arr.reduce((acc, tuple) => {
        tuple.forEach((item, i) => {
            if (!acc[i]) acc[i] = [];
            acc[i].push(item);
        });
        return acc;
    }, []);
}

// ============================================
// OBJECT UTILITIES
// ============================================

/**
 * PickKeys - Creates object with only specified keys
 * @example PickKeys({a:1,b:2,c:3}, ['a','c']) // {a:1,c:3}
 */
function PickKeys(obj, keys) {
    const result = {};
    for (const key of keys) {
        if (key in obj) result[key] = obj[key];
    }
    return result;
}

/**
 * OmitKeys - Creates object excluding specified keys
 * @example OmitKeys({a:1,b:2,c:3}, ['b']) // {a:1,c:3}
 */
function OmitKeys(obj, keys) {
    const result = { ...obj };
    for (const key of keys) {
        delete result[key];
    }
    return result;
}

/**
 * DeepClone - Deep clones object/array
 * @example DeepClone({a:1,b:{c:2}}) // {a:1,b:{c:2}}
 */
function DeepClone(obj) {
    return JSON.parse(JSON.stringify(obj));
}

/**
 * MergeDeep - Deep merges objects (right overrides left)
 * @example MergeDeep({a:1}, {b:2}, {a:3}) // {a:3,b:2}
 */
function MergeDeep(target, ...sources) {
    const result = { ...target };
    for (const source of sources) {
        for (const key in source) {
            if (IsObject(source[key]) && IsObject(result[key])) {
                result[key] = MergeDeep(result[key], source[key]);
            } else {
                result[key] = source[key];
            }
        }
    }
    return result;
}

/**
 * GetNested - Safely gets nested property using dot notation
 * @example GetNested({user: {name: 'John'}}, 'user.name') // 'John'
 */
function GetNested(obj, path, defaultValue = undefined) {
    const keys = path.split('.');
    let result = obj;
    for (const key of keys) {
        if (result === null || result === undefined || !(key in result)) {
            return defaultValue;
        }
        result = result[key];
    }
    return result;
}

/**
 * SetNested - Sets nested property using dot notation
 * @example SetNested({}, 'user.name', 'John') // {user: {name: 'John'}}
 */
function SetNested(obj, path, value) {
    const result = { ...obj };
    const keys = path.split('.');
    let current = result;
    for (let i = 0; i < keys.length - 1; i++) {
        const key = keys[i];
        if (!current[key] || typeof current[key] !== 'object') {
            current[key] = {};
        }
        current = current[key];
    }
    current[keys[keys.length - 1]] = value;
    return result;
}

/**
 * TransformKeys - Transforms object keys using function
 * @example TransformKeys({a:1, b:2}, key => key.toUpperCase()) // {A:1, B:2}
 */
function TransformKeys(obj, transformFn) {
    const result = {};
    for (const key in obj) {
        const newKey = transformFn(key);
        result[newKey] = obj[key];
    }
    return result;
}

/**
 * InvertKeys - Swaps keys and values
 * @example InvertKeys({a:1, b:2}) // {1:'a', 2:'b'}
 */
function InvertKeys(obj) {
    const result = {};
    for (const key in obj) {
        result[obj[key]] = key;
    }
    return result;
}

// ============================================
// STRING UTILITIES
// ============================================

/**
 * RandomString - Generates random alphanumeric string
 * @param {number} length - Desired string length (default: 8)
 * @returns {string} Random string
 * @example RandomString(10) // 'aB3dEf9GhI'
 */
function RandomString(length = 8) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += chars[RandomBetween(0, chars.length - 1)];
    }
    return result;
}

/**
 * Truncate - Truncates string to max length with ellipsis
 * @example Truncate('Hello World', 5) // 'Hello...'
 */
function Truncate(str, maxLength = 50, suffix = '...') {
    if (!IsString(str) || str.length <= maxLength) return str;
    return str.slice(0, maxLength) + suffix;
}

/**
 * CamelCase - Converts string to camelCase
 * @example CamelCase('hello world') // 'helloWorld'
 */
function CamelCase(str) {
    return str.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, (_, char) => char.toUpperCase());
}

/**
 * SnakeCase - Converts string to snake_case
 * @example SnakeCase('Hello World') // 'hello_world'
 */
function SnakeCase(str) {
    return str.replace(/\s+/g, '_').toLowerCase();
}

/**
 * KebabCase - Converts string to kebab-case
 * @example KebabCase('Hello World') // 'hello-world'
 */
function KebabCase(str) {
    return str.replace(/\s+/g, '-').toLowerCase();
}

/**
 * TitleCase - Converts string to Title Case
 * @example TitleCase('hello world') // 'Hello World'
 */
function TitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
}

/**
 * Slugify - Creates URL-friendly slug
 * @example Slugify('Hello World!') // 'hello-world'
 */
function Slugify(str) {
    return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}

// ============================================
// DATE & TIME UTILITIES
// ============================================

/**
 * FormatDate - Formats date object
 * @example FormatDate(new Date(), 'YYYY-MM-DD') // '2026-07-02'
 */
function FormatDate(date, format = 'YYYY-MM-DD') {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');
    
    return format
        .replace('YYYY', year)
        .replace('MM', month)
        .replace('DD', day)
        .replace('HH', hours)
        .replace('mm', minutes)
        .replace('ss', seconds);
}

/**
 * TimeAgo - Returns human-readable time difference
 * @example TimeAgo('2026-07-01') // '1 day ago'
 */
function TimeAgo(date) {
    const now = new Date();
    const diff = now - new Date(date);
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);
    
    if (years > 0) return years + ' year' + (years > 1 ? 's' : '') + ' ago';
    if (months > 0) return months + ' month' + (months > 1 ? 's' : '') + ' ago';
    if (days > 0) return days + ' day' + (days > 1 ? 's' : '') + ' ago';
    if (hours > 0) return hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
    if (minutes > 0) return minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
    return 'just now';
}

/**
 * AddDays - Adds days to date
 * @example AddDays(new Date(), 7) // Date + 7 days
 */
function AddDays(date, days) {
    const result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

/**
 * GetDaysBetween - Returns number of days between two dates
 * @example GetDaysBetween('2026-07-01', '2026-07-10') // 9
 */
function GetDaysBetween(date1, date2) {
    const d1 = new Date(date1);
    const d2 = new Date(date2);
    const diff = Math.abs(d2 - d1);
    return Math.ceil(diff / (1000 * 60 * 60 * 24));
}

// ============================================
// MATH UTILITIES
// ============================================

/**
 * Sum - Sums array of numbers
 * @example Sum([1,2,3,4]) // 10
 */
function Sum(arr) {
    return arr.reduce((acc, val) => acc + val, 0);
}

/**
 * Average - Calculates average of array
 * @example Average([1,2,3,4]) // 2.5
 */
function Average(arr) {
    return Sum(arr) / arr.length;
}

/**
 * Median - Calculates median of array
 * @example Median([1,3,5]) // 3
 */
function Median(arr) {
    const sorted = [...arr].sort((a, b) => a - b);
    const mid = Math.floor(sorted.length / 2);
    return sorted.length % 2 ? sorted[mid] : (sorted[mid - 1] + sorted[mid]) / 2;
}

/**
 * Mode - Finds most frequent value(s)
 * @example Mode([1,2,2,3,3]) // ['2','3']
 */
function Mode(arr) {
    const frequency = {};
    let maxFreq = 0;
    const result = [];
    for (const item of arr) {
        frequency[item] = (frequency[item] || 0) + 1;
        if (frequency[item] > maxFreq) maxFreq = frequency[item];
    }
    for (const key in frequency) {
        if (frequency[key] === maxFreq) result.push(key);
    }
    return result.length === 1 ? result[0] : result;
}

/**
 * Factorial - Calculates factorial of number
 * @example Factorial(5) // 120
 */
function Factorial(n) {
    if (n < 0) return 0;
    if (n <= 1) return 1;
    let result = 1;
    for (let i = 2; i <= n; i++) result *= i;
    return result;
}

/**
 * Fibonacci - Returns Fibonacci number at position n
 * @example Fibonacci(7) // 13
 */
function Fibonacci(n) {
    if (n <= 0) return 0;
    if (n === 1) return 1;
    let a = 0, b = 1;
    for (let i = 2; i <= n; i++) {
        [a, b] = [b, a + b];
    }
    return b;
}

// ============================================
// PROMISE & ASYNC UTILITIES
// ============================================

/**
 * Delay - Returns promise that resolves after milliseconds
 * @example await Delay(1000) // Waits 1 second
 */
function Delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

/**
 * Retry - Retries async function with delay
 * @example await Retry(() => fetch(url), 3, 1000)
 */
async function Retry(fn, retries = 3, delay = 1000) {
    for (let i = 0; i < retries; i++) {
        try {
            return await fn();
        } catch (err) {
            if (i === retries - 1) throw err;
            await Delay(delay);
        }
    }
}

/**
 * Debounce - Creates debounced function
 * @example const debounced = Debounce(fn, 300)
 */
function Debounce(fn, delay = 300) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
}

/**
 * Throttle - Creates throttled function
 * @example const throttled = Throttle(fn, 300)
 */
function Throttle(fn, limit = 300) {
    let inThrottle = false;
    return function(...args) {
        if (!inThrottle) {
            fn.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ============================================
// CHAINING HELPER (Optional)
// ============================================

/**
 * Chain - Wraps value for fluent method chaining
 * @example Chain([1,2,3,4,5]).filter(n=>n>2).shuffle().value
 */
function Chain(value) {
    const wrapper = {
        value: value,
        
        // Type checking
        isString() { wrapper.value = IsString(wrapper.value); return wrapper; },
        isNumber() { wrapper.value = IsNumber(wrapper.value); return wrapper; },
        isArray() { wrapper.value = IsArray(wrapper.value); return wrapper; },
        isObject() { wrapper.value = IsObject(wrapper.value); return wrapper; },
        isEmpty() { wrapper.value = IsEmpty(wrapper.value); return wrapper; },
        isEmail() { wrapper.value = IsEmail(wrapper.value); return wrapper; },
        isURL() { wrapper.value = IsURL(wrapper.value); return wrapper; },
        isPalindrome() { wrapper.value = IsPalindrome(wrapper.value); return wrapper; },
        
        // Array methods
        filter(condition) { wrapper.value = FilterArray(wrapper.value, condition); return wrapper; },
        unique() { wrapper.value = FilterUnique(wrapper.value); return wrapper; },
        falsy() { wrapper.value = FilterFalsy(wrapper.value); return wrapper; },
        shuffle() { wrapper.value = ShuffleArray(wrapper.value); return wrapper; },
        chunk(size) { wrapper.value = ChunkArray(wrapper.value, size); return wrapper; },
        pick() { wrapper.value = RandomPick(wrapper.value); return wrapper; },
        groupBy(key) { wrapper.value = GroupBy(wrapper.value, key); return wrapper; },
        sortBy(key, order) { wrapper.value = SortBy(wrapper.value, key, order); return wrapper; },
        pluck(key) { wrapper.value = Pluck(wrapper.value, key); return wrapper; },
        flatten(depth) { wrapper.value = Flatten(wrapper.value, depth); return wrapper; },
        
        // Object methods
        pickKeys(keys) { wrapper.value = PickKeys(wrapper.value, keys); return wrapper; },
        omitKeys(keys) { wrapper.value = OmitKeys(wrapper.value, keys); return wrapper; },
        deepClone() { wrapper.value = DeepClone(wrapper.value); return wrapper; },
        mergeDeep(...sources) { wrapper.value = MergeDeep(wrapper.value, ...sources); return wrapper; },
        transformKeys(fn) { wrapper.value = TransformKeys(wrapper.value, fn); return wrapper; },
        invertKeys() { wrapper.value = InvertKeys(wrapper.value); return wrapper; },
        
        // Number methods
        clamp(min, max) { wrapper.value = ClampNumber(wrapper.value, min, max); return wrapper; },
        toCurrency(locale, currency) { wrapper.value = ToCurrency(wrapper.value, locale, currency); return wrapper; },
        toPercentage(decimals) { wrapper.value = ToPercentage(wrapper.value, decimals); return wrapper; },
        
        // String methods
        truncate(maxLength, suffix) { wrapper.value = Truncate(wrapper.value, maxLength, suffix); return wrapper; },
        camelCase() { wrapper.value = CamelCase(wrapper.value); return wrapper; },
        snakeCase() { wrapper.value = SnakeCase(wrapper.value); return wrapper; },
        kebabCase() { wrapper.value = KebabCase(wrapper.value); return wrapper; },
        titleCase() { wrapper.value = TitleCase(wrapper.value); return wrapper; },
        slugify() { wrapper.value = Slugify(wrapper.value); return wrapper; },
    };
    return wrapper;
}




// custom marquee
function CustomMarquee() {
    class ViteCSSMarquee {
        constructor(element) {
            this.element = element;
            this.wrapper = null;
            this.animationId = null;
            this.isRunning = false;
            this.canAnimate = true;
            this.currentX = 0;
            this.startX = 0;
            this.endX = 0;
            this.duration = 0;
            this.startTime = null;
            this.eventListeners = [];
            this.config = null;
            this.resizeTimer = null;
            this.resizeObserver = null;
            this.visibilityObserver = null;
            this.contentObserver = null;
            this.RESIZE_DELAY = 250;
            
            this.config = this.parseAttributes();
            this.init();
        }

        parseAttributes() {
            return {
                core: {
                    active: this.element.hasAttribute("vitecss-marquee"),
                    id: this.element.getAttribute("vitecss-marquee-id") || undefined
                },
                animation: {
                    speed: Number(this.element.getAttribute("vitecss-marquee-speed") || 50),
                    direction: this.element.getAttribute("vitecss-marquee-direction") || "left",
                    gap: Number(this.element.getAttribute("vitecss-marquee-gap") || 20),
                    duplicates: Number(this.element.getAttribute("vitecss-marquee-duplicates") || 0)
                },
                behavior: {
                    pauseOnHover: this.element.getAttribute("vitecss-marquee-pause-hover") === "true" || false,
                    loop: Number(this.element.getAttribute("vitecss-marquee-loop") || -1),
                    pauseWhenNotVisible: this.element.getAttribute("vitecss-marquee-pause-visible") === "true" || false
                },
                checkOverflow: {
                    toCheck: this.element.hasAttribute('vitecss-marquee-check')
                }
            };
        }

        init() {
            this.setupWrapper();
            
            setTimeout(() => {
                this.checkAndStart();
            }, 100);
            
            this.bindEvents();
            this.bindResizeEvent();
            this.setupContentObserver();
            
            if (this.config.behavior.pauseWhenNotVisible) {
                this.setupVisibilityObserver();
            }
        }

        checkAndStart() {
            if (this.shouldAnimate()) {
                this.start();
            } else {
                console.log(`[Marquee ${this.config.core.id || 'unnamed'}] Content does not overflow - animation prevented`);
                this.stop();
                this.canAnimate = false;
            }
        }

        shouldAnimate() {
            if (!this.config.checkOverflow.toCheck) {
                return true;
            }
            
            const containerWidth = this.element.clientWidth;
            const contentWidth = this.getTotalWidth();
            const overflows = contentWidth > containerWidth;
            
            return overflows;
        }

        recheckOverflow() {
            if (!this.config.checkOverflow.toCheck) return;
            
            // Store current state
            const wasAnimating = this.isRunning;
            
            // Re-evaluate
            const shouldAnimate = this.shouldAnimate();
            
            if (shouldAnimate && !this.canAnimate) {
                console.log('[Marquee] Overflow detected - starting animation');
                this.canAnimate = true;
                this.stop();
                this.start();
            } else if (!shouldAnimate && this.canAnimate) {
                console.log('[Marquee] No overflow - stopping animation');
                this.canAnimate = false;
                this.stop();
            } else if (shouldAnimate && wasAnimating) {
                // If already animating, just continue
                return;
            }
        }

        setupContentObserver() {
            // Create a mutation observer to watch for content changes
            this.contentObserver = new MutationObserver((mutations) => {
                let contentChanged = false;
                
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList' || mutation.type === 'characterData') {
                        contentChanged = true;
                    }
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        contentChanged = true;
                    }
                });
                
                if (contentChanged) {
                    console.log('[Marquee] Content changed - rechecking overflow');
                    // Small delay to allow DOM to update
                    setTimeout(() => {
                        this.recheckOverflow();
                    }, 50);
                }
            });
            
            // Observe the wrapper for content changes
            if (this.wrapper) {
                this.contentObserver.observe(this.wrapper, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            }
            
            // Also observe the original element for attribute changes
            this.contentObserver.observe(this.element, {
                attributes: true,
                attributeFilter: ['style', 'class']
            });
            
            this.eventListeners.push(() => this.contentObserver.disconnect());
        }

        setupWrapper() {
            this.setWrapperStyles();
            this.createClonesAndAddStyles();
        }

        setWrapperStyles() {
            this.wrapper = document.createElement("div");
            this.wrapper.style.display = "flex";
            this.wrapper.style.flexWrap = "nowrap";
            this.wrapper.style.position = "relative";
            this.wrapper.style.width = "max-content";
            this.wrapper.style.willChange = "transform";
            this.wrapper.style.backfaceVisibility = "hidden";
            this.wrapper.style.justifyContent = "flex-start";
            this.wrapper.style.alignItems = "center";
            this.wrapper.style.gap = this.getGapValue();
        }

        createClonesAndAddStyles() {
            let gap = this.getGapValue();
            
            let originalChildren = Array.from(this.element.children);
            
            if (originalChildren.length === 0) {
                console.error('[Marquee] No content found inside marquee element');
                return;
            }
            
            let originalHTML = this.element.innerHTML;
            
            this.element.style.justifyContent = "flex-start";
            this.element.style.overflow = "hidden";
            this.element.style.width = "100%";
            this.element.style.position = "relative";
            this.element.innerHTML = "";
            
            this.wrapper.innerHTML = originalHTML;
            
            let wrapperChildren = this.wrapper.children;
            for (let i = 0; i < wrapperChildren.length; i++) {
                wrapperChildren[i].style.flexShrink = "0";
                wrapperChildren[i].style.minWidth = "max-content";
            }
            
            let duplicates = this.config.animation.duplicates;
            for (let i = 0; i < duplicates; i++) {
                let clone = document.createElement("div");
                clone.innerHTML = originalHTML;
                clone.style.display = "flex";
                clone.style.gap = gap;
                clone.style.flexShrink = "0";
                
                let cloneChildren = clone.children;
                for (let j = 0; j < cloneChildren.length; j++) {
                    cloneChildren[j].style.flexShrink = "0";
                    cloneChildren[j].style.minWidth = "max-content";
                }
                
                this.wrapper.appendChild(clone);
            }
            
            this.element.appendChild(this.wrapper);
        }

        getGapValue() {
            let computedGap = window.getComputedStyle(this.element).getPropertyValue("gap");
            if (computedGap && computedGap !== "0px" && computedGap !== "normal") {
                return computedGap;
            }
            return `${this.config.animation.gap}px`;
        }

        getTotalWidth() {
            if (!this.wrapper || !this.wrapper.firstElementChild) return 0;
            
            let gapValue = parseFloat(this.getGapValue()) || 0;
            let totalWidth = 0;
            
            for (let i = 0; i < this.wrapper.children.length; i++) {
                totalWidth += this.wrapper.children[i].scrollWidth;
                if (i < this.wrapper.children.length - 1) {
                    totalWidth += gapValue;
                }
            }
            
            return totalWidth;
        }

        startAnimation() {
            if (!this.shouldAnimate()) {
                console.log('[Marquee] startAnimation prevented - no overflow');
                this.canAnimate = false;
                return;
            }
            
            if (!this.wrapper) {
                console.error('[Marquee] Wrapper not initialized');
                return;
            }
            
            let totalWidth = this.getTotalWidth();
            let containerWidth = this.element.clientWidth;
            let direction = this.config.animation.direction;
            
            if (totalWidth === 0) {
                console.error('[Marquee] Total width is 0, cannot animate');
                return;
            }
            
            if (direction === "left") {
                this.startX = containerWidth;
                this.endX = -totalWidth;
            } else {
                this.startX = -totalWidth;
                this.endX = containerWidth;
            }
            
            let distance = Math.abs(this.endX - this.startX);
            this.duration = (distance / this.config.animation.speed) * 1000;
            
            this.currentX = this.startX;
            this.wrapper.style.transform = `translate3d(${this.currentX}px, 0, 0)`;
            
            this.isRunning = true;
            this.startTime = performance.now();
            this.animate();
        }

        animate(currentTime = null) {
            if (!this.isRunning) return;
            
            if (this.config.checkOverflow.toCheck && !this.shouldAnimate()) {
                this.pause();
                this.canAnimate = false;
                return;
            }
            
            if (currentTime === null) {
                currentTime = performance.now();
            }
            
            let elapsed = currentTime - this.startTime;
            let progress = Math.min(elapsed / this.duration, 1);
            
            this.currentX = this.startX + (this.endX - this.startX) * progress;
            this.wrapper.style.transform = `translate3d(${this.currentX}px, 0, 0)`;
            
            if (progress >= 1) {
                this.currentX = this.startX;
                this.wrapper.style.transform = `translate3d(${this.currentX}px, 0, 0)`;
                this.startTime = performance.now();
                this.animationId = requestAnimationFrame((time) => this.animate(time));
            } else {
                this.animationId = requestAnimationFrame((time) => this.animate(time));
            }
        }

        bindEvents() {
            if (this.config.behavior.pauseOnHover) {
                let pauseHandler = () => this.pause();
                let resumeHandler = () => this.resume();
                
                this.element.addEventListener("mouseenter", pauseHandler);
                this.element.addEventListener("mouseleave", resumeHandler);
                
                this.eventListeners.push(() => {
                    this.element.removeEventListener("mouseenter", pauseHandler);
                    this.element.removeEventListener("mouseleave", resumeHandler);
                });
            }
        }

        bindResizeEvent() {
            let resizeHandler = () => {
                if (this.resizeTimer) clearTimeout(this.resizeTimer);
                this.resizeTimer = setTimeout(() => {
                    let wasRunning = this.isRunning;
                    if (wasRunning) this.pause();
                    this.updateDimensions();
                    this.recheckOverflow();
                    if (wasRunning && this.canAnimate) this.resume();
                }, this.RESIZE_DELAY);
            };
            
            window.addEventListener("resize", resizeHandler);
            this.eventListeners.push(() => {
                window.removeEventListener("resize", resizeHandler);
                if (this.resizeTimer) clearTimeout(this.resizeTimer);
            });
            
            if (window.ResizeObserver) {
                this.resizeObserver = new ResizeObserver(() => {
                    if (this.resizeTimer) clearTimeout(this.resizeTimer);
                    this.resizeTimer = setTimeout(() => {
                        this.recheckOverflow();
                        if (this.isRunning && this.canAnimate) {
                            this.updateDimensions();
                        }
                    }, this.RESIZE_DELAY);
                });
                this.resizeObserver.observe(this.element);
                this.eventListeners.push(() => this.resizeObserver.disconnect());
            }
        }

        updateDimensions() {
            if (!this.canAnimate) return;
            
            let totalWidth = this.getTotalWidth();
            let containerWidth = this.element.clientWidth;
            let direction = this.config.animation.direction;
            
            if (direction === "left") {
                this.startX = containerWidth;
                this.endX = -totalWidth;
            } else {
                this.startX = -totalWidth;
                this.endX = containerWidth;
            }
            
            let distance = Math.abs(this.endX - this.startX);
            this.duration = (distance / this.config.animation.speed) * 1000;
            
            this.currentX = this.startX;
            this.wrapper.style.transform = `translate3d(${this.currentX}px, 0, 0)`;
        }

        setupVisibilityObserver() {
            this.visibilityObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (this.canAnimate) this.resume();
                    } else {
                        this.pause();
                    }
                });
            }, { root: null, threshold: 0.1 });
            
            this.visibilityObserver.observe(this.element);
            this.eventListeners.push(() => this.visibilityObserver.disconnect());
        }

        pause() {
            if (this.isRunning) {
                this.isRunning = false;
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                    this.animationId = null;
                }
            }
        }

        resume() {
            if (!this.canAnimate) {
                console.log('[Marquee] Resume prevented - content does not overflow');
                return;
            }
            
            if (!this.isRunning && this.wrapper) {
                this.isRunning = true;
                this.startTime = performance.now() - (this.startTime ? (performance.now() - this.startTime) : 0);
                this.animate();
            }
        }

        start() {
            if (!this.shouldAnimate()) {
                this.canAnimate = false;
                console.log('[Marquee] Start prevented - content does not overflow');
                return;
            }
            
            this.canAnimate = true;
            
            if (!this.isRunning) {
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                }
                this.startAnimation();
            }
        }

        stop() {
            if (this.isRunning) {
                this.isRunning = false;
                if (this.animationId) {
                    cancelAnimationFrame(this.animationId);
                    this.animationId = null;
                }
                if (this.wrapper) {
                    this.currentX = 0;
                    this.wrapper.style.transform = `translate3d(0, 0, 0)`;
                }
            }
        }

        update(config) {
            if (config.animation?.speed && config.animation.speed <= 0) {
                console.warn("[Marquee] Animation speed must be greater than 0");
                return;
            }
            
            if (config.animation) {
                this.config.animation = { ...this.config.animation, ...config.animation };
            }
            
            if (config.behavior) {
                this.config.behavior = { ...this.config.behavior, ...config.behavior };
            }
            
            let wasRunning = this.isRunning;
            if (wasRunning) this.pause();
            
            if (this.wrapper) {
                this.wrapper.style.gap = this.getGapValue();
            }
            
            this.updateDimensions();
            this.recheckOverflow();
            
            if (wasRunning && this.canAnimate) this.resume();
        }

        destroy() {
            this.stop();
            if (this.resizeTimer) clearTimeout(this.resizeTimer);
            this.eventListeners.forEach(cleanup => cleanup());
            this.eventListeners = [];
            if (this.wrapper && this.wrapper.parentNode) {
                this.wrapper.parentNode.removeChild(this.wrapper);
            }
        }
    }

    // Make initializeMarquees globally available
    window.initializeMarquees = function() {
        console.log('Initializing marquees...');
        const marquees = document.querySelectorAll("[vitecss-marquee]");
        console.log(`Found ${marquees.length} marquees`);
        marquees.forEach(element => {
            if (!element.vitecssMarquee) {
                let marquee = new ViteCSSMarquee(element);
                element.vitecssMarquee = marquee;
            }
        });
    };

    // Auto-initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initializeMarquees);
    } else {
        window.initializeMarquees();
    }

    window.vitecssMarquee = ViteCSSMarquee;
}

// Execute the function
CustomMarquee();


   
function IsJSONABLE(data){
    try{
      JSON.parse(data);
      return true;
    }catch{
        return false;
    }
}


// post request
async function PostRequest(event,element,callback=null,notify=null,btn_text=null){
  try{
      event.preventDefault();
 let inputs=element.querySelectorAll('.inp.required');
 
 
 let isEmpty = false;

 if(inputs){
    
    
    inputs.forEach((input)=>{
         let cont=input.closest('.cont');
        //  FIRST REMOVE EMPTY STATE
         if(cont){
         
        
            cont.classList.remove('empty');
           
           }else{
          
             input.classList.remove('empty');
            
           }
        //    CHECK FOR EMPTY INPUTS THAT ARE REQUIRED

        if(input.value.trim() == ''){
            isEmpty=true;
          
           
        if(cont){
            cont.classList.add('empty');
            
        }else{
              input.classList.add('empty');
        }
        }

    });
 }
 
 if(!isEmpty){
    // loading state
   let post_btn=element.querySelector('button');
   if(post_btn){
    let data_text=post_btn.dataset.text;
    if(!data_text){
        post_btn.dataset.text=post_btn.innerHTML;
    }
     post_btn.classList.toggle('disabled');
     post_btn.innerHTML=btn_text ?? 'Processing...';
   }


    let inps=element.querySelectorAll('.input');
    let form=new FormData();
    let val;
   
    inps.forEach((inp)=>{
        val=inp.value;
        if(inp.hasAttribute('vitecss-value')){
            val=inp.getAttribute('vitecss-value');
        }
       form.append(inp.name,val);

    });
    // check for photos
    let files=element.querySelectorAll('input[type=file]');
    if(files){
        files.forEach((inp)=>{
            let file=inp.files[0];
            if(file){
                form.append(inp.name,file);
            }
        })
    }

    
    let response=await fetch(element.action,{
        method : 'POST',
        body : form
     });
     
     if(response.ok){
        let data=await response.text();
        
        if(IsJSONABLE(data)){
            let json=JSON.parse(data);
            if(notify == null){
            CreateNotify(json.status,json.message);

            }
        }else{
            CreateNotify('error',data);
        }
        if(callback !== null){
            callback(data,event);
        }
       if(post_btn){
         post_btn.innerHTML=post_btn.dataset.text;
        post_btn.classList.toggle('disabled');
       }
     }else{
        if(post_btn){
         post_btn.innerHTML=post_btn.dataset.text;
        post_btn.classList.toggle('disabled');
       }
        CreateNotify('error','Internal Error: ' + response.status + ' Error');
        if(response.status == 419){
        window.location.reload();
    }
        
     }
     
 }
  }catch(error){
    CreateNotify('error',error);
    element.querySelector('button').classList.remove('active');
    
  }
}



// create notify
function CreateNotify(status,message){
    let notifies=document.querySelectorAll('.notify');
    if(notifies){
        notifies.forEach((notify)=>{
            notify.remove();
        })
    }
  let section=document.createElement('section');
  section.classList.add('notify');
  section.classList.add(status);
  let icon=status == 'success' ? '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>' : (status == 'error' ? '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 10.5858L9.17157 7.75736L7.75736 9.17157L10.5858 12L7.75736 14.8284L9.17157 16.2426L12 13.4142L14.8284 16.2426L16.2426 14.8284L13.4142 12L16.2426 9.17157L14.8284 7.75736L12 10.5858Z"></path></svg>' : '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11V17H13V11H11ZM11 7V9H13V7H11Z"></path></svg>');


  section.innerHTML=` <div class="row g-5 w-full p-5 notify-body space-between align-center">
           <i class="notify-symbol">${icon}</i>
             <div class="column m-right-auto g-5">
              <strong style="text-transform:capitalize;" class="notify-status">
            ${status}
        </strong>
            <div class="message">
            ${message}
        </div>
             </div>
        <div onclick="HideNotify()" class="pc-pointer m-bottom-auto no-select" style="font-size:2rem">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
        </div>
        </div>`;
       
       
       
       
        document.body.appendChild(section);
        let RemoveNotify=setTimeout(()=>{
            section.remove();
        },5000);
    
}
function HideNotify(){
  let notify= document.querySelector('.notify');
    if(notify){
     notify.remove();
    }
}

// SEND GET REQUEST

/**
 * GetRequest - Perform an asynchronous GET request with optional query parameters
 * 
 * param {string} url - The endpoint URL (can include existing query parameters)
 * param {Object|null} getData - Optional object containing key-value pairs to append as query parameters
 * param {Function|null} callback - Optional callback function (data, error) => void
 * returns {Promise<string>} - Returns the response text
 * 
 * example
 * // Simple GET request
 * const data = await SendGetRequest('https://api.example.com/users');
 * 
 * example
 * // GET with query parameters
 * const data = await SendGetRequest('https://api.example.com/users', {
 *     id: 123,
 *     sort: 'asc',
 *     limit: 10
 * });
 * // Result URL: https://api.example.com/users?id=123&sort=asc&limit=10
 * 
 * example
 * // GET with existing URL parameters
 * const data = await SendGetRequest('https://api.example.com/users?active=true', {
 *     sort: 'desc'
 * });
 * // Result URL: https://api.example.com/users?active=true&sort=desc
 * 
 * example
 * // Using callback pattern
 * SendGetRequest('https://api.example.com/data', { page: 2 }, (data, error) => {
 *     if (error) {
 *         console.error('Error:', error);
 *     } else {
 *         console.log('Data:', data);
 *     }
 * });
 */
async function SendGetRequest(url, getData = null, callback = null) {
    try {
        // If data is provided, append it to URL as query parameters
        if (getData) {
            const queryString = new URLSearchParams(getData).toString();
            url = url + (url.includes('?') ? '&' : '?') + queryString;
        }
        
        let response = await fetch(url, {
            method: 'GET'
        });
        
        let data = await response.text();
        
        if (callback) {
            callback(data, response.ok ? null : 'Error: ' + response.status);
        }
        
        return data;
    } catch (error) {
        if (callback) callback(null, error.message);
        throw error;
    }
}
// SEND POST REQUEST
/**
 * Perform an asynchronous POST request with FormData
 * 
 * param {string} url - The endpoint URL
 * param {Object} postData - Object containing key-value pairs to send as FormData
 * param {Function|null} [callback=null] - Optional callback function (data, error) => void
 * returns {Promise<string>} - Returns the response text
 * 
 * example
 * // Simple POST request
 * const data = await SendPostRequest('https://api.example.com/users', {
 *     name: 'John Doe',
 *     email: 'john@\example.com',
 *     age: 30
 * });
 * 
 * example
 * // POST with file upload
 * const fileInput = document.getElementById('fileInput');
 * const data = await SendPostRequest('https://api.example.com/upload', {
 *     file: fileInput.files[0],
 *     description: 'Profile picture'
 * });
 * 
 * example
 * // Using callback pattern
 * SendPostRequest('https://api.example.com/submit', { data: 'value' }, (data, error) => {
 *     if (error) {
 *         console.error('Error:', error);
 *     } else {
 *         console.log('Response:', data);
 *     }
 * });
 */
async function SendPostRequest(url, postData, callback = null) {
    try {
        let form = new FormData();
        Object.keys(postData).forEach(key => form.append(key, postData[key]));
        
        let response = await fetch(url, {
            method: 'POST',
            body: form
        });
        
        let data = await response.text();
        
        if (callback) {
            callback(data, response.ok ? null : 'Error: ' + response.status);
        }
    } catch (error) {
        if (callback) callback(null, error.message);
    }
}

// copy
async function copy(data) {
    // Helper function for fallback copy (works on older iOS)
    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.top = '-9999px';
        textarea.style.left = '-9999px';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        
        textarea.select();
        textarea.setSelectionRange(0, text.length);
        
        let success = false;
        
            success = document.execCommand('copy');
        
        
        document.body.removeChild(textarea);
        return success;
    }
    
   
        // Try modern Clipboard API first (newer iPhones iOS 13.4+)
        if (navigator.clipboard && window.isSecureContext && navigator.clipboard.writeText) {
            await navigator.clipboard.writeText(data);
            // CreateNotify('success', 'Copied successfully');
        } 
        // Fallback for older iPhones (iOS 9-13.3)
        else {
            const success = fallbackCopy(data);
            if (success) {
                // CreateNotify('success', 'Copied successfully');
            }
        }
    
}

// stop propagation
function StopPropagation(event){
    event.stopPropagation();
}

// preview photo
function PreviewPhoto(element, label) {
    let file = element.files[0];
    
    // Remove any existing preview image
    const existingImg = label.querySelector('img[vitecss-photo-preview]');
    if (existingImg) existingImg.remove();
    
    const children = Array.from(label.children);
    
    if (file) {
        // Hide all children with d-none class
        children.forEach(child => {
            child.classList.add('d-none');
        });
        
        let img = document.createElement('img');
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        img.style.pointerEvents = 'none';
        img.setAttribute('vitecss-photo-preview', 'true');
        img.src = URL.createObjectURL(file);
        
        label.appendChild(img);
    } else {
        // Show all children by removing d-none class
        children.forEach(child => {
            child.classList.remove('d-none');
        });
    }
}
// hide loading
function HideLoading(){
    let loading=document.querySelector(".loading-state");
    if(loading){
        
        loading.remove()
        
    }
        
   

}
// set vh
function SetWindowHeight(){
     let height=window.innerHeight;
    if(window.visualViewport){
        height=window.visualViewport.height;
    }
   
    document.body.style.minHeight=height + 'px';
}



// Store cleanup functions for body-related items only
window._bodyCleanupFunctions = [];

// Register body-specific cleanup
function registerBodyCleanup(cleanupFn) {
    window._bodyCleanupFunctions.push(cleanupFn);
}

// Clean only body-related items before navigation
function cleanupBodyBeforeNavigate() {
    window._bodyCleanupFunctions.forEach(fn => {
        try {
            fn();
        } catch(e) {
            console.error('Body cleanup error:', e);
        }
    });
    window._bodyCleanupFunctions = [];
}

/**
 * SPA ENGINE WITH AUTOMATIC LIFECYCLE CLEANUP
 * -------------------------------------------
 * This script patches global browser functions to track and 
 * automatically remove listeners and timers between page loads.
 */

// 1. REGISTRY: Tracks all active page-level background processes
window.spaRegistry = {
    intervals: new Set(),
    timeouts: new Set(),
    listeners: [],

    // The "Nuke" function to wipe the slate clean
    cleanup() {
        // Clear all tracked intervals
        this.intervals.forEach(id => clearInterval(id));
        this.intervals.clear();

        // Clear all tracked timeouts
        this.timeouts.forEach(id => clearTimeout(id));
        this.timeouts.clear();

        // Remove all tracked event listeners
        this.listeners.forEach(({ target, type, fn, options }) => {
            target.removeEventListener(type, fn, options);
        });
        this.listeners = [];
        
        console.log("SPA: Cleanup complete. Intervals, timeouts, and listeners cleared.");
    }
};

// 2. MONKEY PATCHING: Intercept globals to auto-register them
const nativeInterval = window.setInterval;
const nativeTimeout = window.setTimeout;
const nativeAddListener = window.addEventListener;

window.setInterval = (fn, delay) => {
    const id = nativeInterval(fn, delay);
    window.spaRegistry.intervals.add(id);
    return id;
};

window.setTimeout = (fn, delay) => {
    const id = nativeTimeout(fn, delay);
    window.spaRegistry.timeouts.add(id);
    return id;
};

window.addEventListener = function(type, fn, options) {
    // We track listeners on window and document as they cause the most "leaks"
    if (this === window || this === document) {
        window.spaRegistry.listeners.push({ target: this, type, fn, options });
    }
    nativeAddListener.call(this, type, fn, options);
};



     function trickleLoader(element, options = {}) {
    const {
        onComplete = null, // callback when done
            startPercent = 0,
            endPercent = 80,
            showLabel = true, // show percentage text
            fastZone = 30,
            mediumZone = 60,
            slowZone = 80,
    } = options;
    
    let progress = startPercent;
    let running = false;
    let timer = null;
    
    // Create internal elements if needed
    const bar = element.querySelector('.progress-bar') || element;
    const label = element.querySelector('.progress-label') || null;
    
    function getIncrement() {
        const p = progress;
        if (p < fastZone) return 5 + Math.random() * 8;
        if (p < mediumZone) return 2 + Math.random() * 4;
        if (p < slowZone) return 0.5 + Math.random() * 1.5;
        return 0.1 + Math.random() * 0.3;
    }
    
    function getDelay() {
        const p = progress;
        if (p < fastZone) return 60 + Math.random() * 60;
        if (p < mediumZone) return 100 + Math.random() * 100;
        if (p < slowZone) return 200 + Math.random() * 200;
        return 300 + Math.random() * 400;
    }
    
    function updateUI(value) {
        const pct = Math.round(value);
        
        // Update bar
        if (bar.style) {
            bar.style.width = pct + '%';
        }
        
        // Update label
        if (showLabel) {
            if (label) {
                label.textContent = pct + '%';
            } else if (element.tagName === 'DIV' && !element.classList.contains('progress-bar')) {
                // If element is a container, add label
                let lbl = element.querySelector('.progress-label');
                if (!lbl) {
                    lbl = document.createElement('span');
                    lbl.className = 'progress-label';
                    element.appendChild(lbl);
                }
                lbl.textContent = pct + '%';
            }
        }
    }
    
    function step() {
        if (!running) return;
        
        progress += getIncrement();
        progress = Math.min(progress, endPercent);
        
        updateUI(progress);
        
        if (progress < endPercent) {
            timer = setTimeout(step, getDelay());
        }
    }
    
    function start() {
        if (running) return;
        running = true;
        step();
        return api;
    }
    
    function complete() {
        running = false;
        if (timer) clearTimeout(timer);
        progress = 100;
        updateUI(100);
        if (onComplete) onComplete();
        return api;
    }
    
    function stop() {
        running = false;
        if (timer) clearTimeout(timer);
        return api;
    }
    
    function getProgress() {
        return Math.round(progress);
    }
    
    function setProgress(value) {
        progress = Math.min(value, 99);
        updateUI(progress);
        return api;
    }
    
    const api = { start, complete, stop, getProgress, setProgress };
    
    // Auto-start if requested
    if (options.autoStart) {
        start();
    }
    
    return api;
}


// 3. THE SPA FUNCTION: Handles navigation and surgical DOM updates
async function spa(url) {
    // Start Loading UI
    let bar = document.createElement('div');
    bar.classList.add('vite-loader');
    document.body.appendChild(bar);
    let loader_child=document.createElement('div');
   loader_child.classList.add('child');
    bar.appendChild(loader_child)
    let loader=trickleLoader(document.querySelector('.vite-loader .child'));
    loader.start();

    try {
        // Fire Start Events
        document.dispatchEvent(new Event('vitecss:navigate'));

        // Fetch new content
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response failed');
        
        const data = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');
    
        // --- THE CLEANUP PHASE ---
        window.spaRegistry.cleanup();

        // --- THE UPDATE PHASE ---
        loader_child.style.transition='all 0.2s ease';
        loader.complete();

        await new Promise(r => setTimeout(r, 200));
        // Update Title
        document.title = doc.title;

        // Update Styles (Remove old .css styles, inject new ones)
        document.querySelectorAll('head style.css').forEach(s => s.remove());
        doc.querySelectorAll('head style.css').forEach(style => {
            const newStyle = document.createElement('style');
            newStyle.className = 'css';
            newStyle.textContent = style.textContent;
            document.head.appendChild(newStyle);
        });

        // Update Styles - Link tags with .css class pattern (lowercase)
// Remove old .css link tags
document.querySelectorAll('head link.css').forEach(link => link.remove());

// Inject new link tags from response
doc.querySelectorAll('head link.css').forEach(link => {
    const newLink = document.createElement('link');
    newLink.className = 'css';
    newLink.rel = link.rel || 'stylesheet';
    newLink.href = link.href;
    newLink.media = link.media || 'all';
    // Copy any other attributes (integrity, crossorigin, etc.)
    if (link.integrity) newLink.integrity = link.integrity;
    if (link.crossOrigin) newLink.crossOrigin = link.crossOrigin;
    document.head.appendChild(newLink);
});

        // Update Body Content
        document.body.innerHTML = doc.body.innerHTML;

        // Push to History
        history.pushState({ url }, doc.title, url);

        // --- THE RE-ACTIVATION PHASE ---
        
        // Find and re-execute scripts in the new body
        // (Native innerHTML injection doesn't execute <script> tags)
        document.body.querySelectorAll('script').forEach(oldScript => {
            const newScript = document.createElement('script');
            
            // Copy all attributes (src, type, etc.)
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            // Copy script content
            newScript.textContent = oldScript.textContent;
            
            // Replace to trigger execution
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });

        // Fire Success Event
        document.dispatchEvent(new Event('vitecss:navigated'));

    } catch (error) {
        console.error('SPA Error:', error);
        document.dispatchEvent(new Event('vitecss:navigate-error'));
         window.location.href=url;
    } finally {
        // Remove Loading UI
        if (loader){
          loader.stop();
        }
       
    }
}

// 4. BROWSER BACK/FORWARD SUPPORT
window.onpopstate = function(event) {
    if (event.state && event.state.url) {
        spa(event.state.url);
    }
};

// Vitecss
window.Vitecss = {
    navigate : (url)=>{
        spa(url)
    }
}

// calling functions
function GeneralStyles(){
    if(document.querySelector('.loading-state')){
        document.querySelector('.loading-state').remove();
    }
      
}

// remove empty class from inputs and conts

function UnEmpty(){
    let inps=document.querySelectorAll('.inp.required');
    if(inps){
        inps.forEach((inp)=>{
           inp.addEventListener('focus',()=>{
             let cont=inp.closest('.cont');
            if(cont){
                cont.classList.remove('empty');
            }else{
                inp.classList.remove('empty');
            }
           })
        })
    }
}
// number Format
function FormatNumber(number,fraction_digits=0){
let formatter=new Intl.NumberFormat('en-US',{
    minimumFractionDigits : fraction_digits,
    maximumFractionDigits : fraction_digits
});
return formatter.format(number);
}


window.addEventListener('load',()=>{
    
    GeneralStyles();
    SetWindowHeight();
    CustomMarquee();
    UnEmpty();
    
});




// vitecss navigated
document.addEventListener('vitecss:navigated',()=>{
    GeneralStyles();
    SetWindowHeight();
    UnEmpty();
    CustomMarquee();

});

 
 

