
#### Say, the content site got hacked, therefore when fetching the content URL for content parsing it can keep redirecting, how to solve this scenario?

- one way around will be to kill the job, as it will be redirecting, it will fail to get parsed and if we set a counter for the number of attempt taken and remove it after all the attempts fail. 

#### Say, the content site got hacked, therefore when fetching the content URL for content parsing it can inject virus / malware / adware. how to guard this?

- if we sanitize data properly and strongly validate the type of data we are expecting, it will reduce the impact of the attack.

#### Say, that URL can contain NSFW contents, how to flag NSFW? so that those don't get included in the suggestion system we may develop in future?

- by using regex pattern to validate and remove NSFW contents

