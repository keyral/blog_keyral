notification :off

guard 'sass',
	:input => 'sass',
	:output => 'css',
	:require => 'sass-globbing'

## Uncomment this if you wish to clear the theme registry every time you
## change one of the relevant theme files.
# guard :shell do
#   puts 'Monitoring theme files.'
# 
#   watch(%r{.+\.(php|inc|info)$}) { |m|
#     puts 'Change detected: ' + m[0]
#     `drush cache-clear theme-registry`
#     puts 'Cleared theme registry.'
#   }
# end

# https://github.com/guard/guard-livereload.
# Ignore *.normalize.scss to prevent flashing content when re-rendering.
guard 'livereload' do
  # watch(%r{^((?!\.normalize\.).)*\.(css|js)$})
  watch(%r{.+\.(css|twig|js)$})
  # puts 'Reloading browser.'
end