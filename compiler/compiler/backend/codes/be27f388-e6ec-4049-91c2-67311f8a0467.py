def reverse_string(s):
    left, right = 0, len(s) - 1
    while left < right:
        s[left], s[right] = s[right], s[left]
        left += 1
        right -= 1

chars = ['h', 'e', 'l', 'l', 'o']
reverse_string(chars)
print(chars)  