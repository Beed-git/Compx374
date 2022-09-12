package com.google.ar.core.examples.java.common.rendering;

import com.google.ar.core.examples.java.common.samplerender.SampleRender;
import com.google.ar.core.examples.java.common.samplerender.Texture;

import java.io.IOException;

public class AnimatedTexture implements ITexture {
    private final SampleRender render;

    private ImageTexture imageTexture;

    private int frame = 0;
    private String[] assets;

    public AnimatedTexture(SampleRender render, String assetFolder, Texture.ColorFormat colorFormat) {
        this.render = render;
        try {
            this.assets = getAssetNames(render, assetFolder);
            this.imageTexture = ImageTexture.createFromAsset(render, assets[0]);

        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    private String[] getAssetNames(SampleRender render, String assetFolder) throws IOException {
        String[] files = render.getAssets().list(assetFolder);
        String[] paths = new String[files.length];
        for (int i = 0; i < files.length; i++) {
            paths[i] = assetFolder + "/" + files[i];
        }
        return paths;
    }

    @Override
    public int getTextureId() {
        return this.imageTexture.getTextureId();
    }

    @Override
    public void bind() {
        this.imageTexture.bind();
    }


    public void nextFrame() {
        // Get the next frame in the folder.
        frame = (frame + 1) % assets.length;
        String asset = assets[frame];
        try {
            // Load the asset, then update the texture with the data from the asset.
            ImageBuffer image = ImageBuffer.fromBitmap(render, asset);
            imageTexture.setData(image.getWidth(), image.getHeight(), image.getBuffer());

        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    @Override
    public void close() {
        imageTexture.close();
    }
}
