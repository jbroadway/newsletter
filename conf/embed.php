; <?php/*

[newsletter/subscribe_widget]

label = "Newsletter: Subscribe Form"

list[label] = "Subscriber list"
list[type] = select
list[not equals] = 0
list[require] = "apps/newsletter/lib/Functions.php"
list[callback] = "newsletter_list_names"

fwd[label] = "Redirect to thank you page (optional)"
fwd[type] = text

tags[label] = "Tags (comma-separated)"
tags[type] = text

; */ ?>