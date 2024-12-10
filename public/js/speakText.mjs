import * as PlayHT from 'playht';
import fs from 'fs';

// Initialize client with your PlayHT credentials
PlayHT.init({
  userId: 'yDDCpJ5JyTU7vx9uAOPtBcd2Eez1', // Replace with your PlayHT User ID
  apiKey: '7bb33aee3e1b4d318b83210879aea0db', // Replace with your PlayHT API Key
});

async function streamAudio(text, outputPath) {
  const stream = await PlayHT.stream(text, { voiceEngine: 'Play3.0-mini' });
  stream.on('data', (chunk) => {
    // Save the audio stream to a file
    fs.appendFileSync(outputPath, chunk);
  });

  return outputPath;
}

// Export the function to be used in Laravel
export { streamAudio };
