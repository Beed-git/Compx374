package com.google.ar.core.examples.java.common.rendering;

import android.opengl.GLES20;
import android.opengl.GLES30;

import com.google.ar.core.examples.java.common.samplerender.GLError;
import com.google.ar.core.examples.java.common.samplerender.SampleRender;
import com.google.ar.core.examples.java.common.samplerender.Texture;

import java.io.Closeable;
import java.io.IOException;

public class AnimatedTexture implements Closeable {
    private final SampleRender render;
    private final Texture.ColorFormat colorFormat;
    private Texture texture;

    private int frame = 0;
    private String[] assets;

    public AnimatedTexture(SampleRender render, String assetFolder, Texture.ColorFormat colorFormat) {
        this.render = render;
        this.colorFormat = colorFormat;
        try {
            this.assets = getAssetNames(render, assetFolder);
            this.texture = Texture.createFromAsset(render, assets[0], Texture.WrapMode.REPEAT, colorFormat);
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

    public void nextFrame() {
        // Get the next frame in the folder.
        frame = (frame + 1) % assets.length;
        String asset = assets[frame];
        try {
            this.texture.close();
            this.texture = Texture.createFromAsset(this.render, asset, Texture.WrapMode.REPEAT, colorFormat);

            // Load the asset, then update the texture with the data from the asset.
            //ImageBuffer image = ImageBuffer.fromBitmap(render, asset);
            //GLES30.glBindTexture(GLES30.GL_TEXTURE_2D, texture.getTextureId());
            //GLError.maybeThrowGLException("Failed to bind texture", "glBindTexture");

            //GLES30.glTexSubImage2D(
            //        GLES30.GL_TEXTURE_2D,
            //        0,
            //        colorFormat.glesEnum,
            //        image.getWidth(),
            //        image.getHeight(),
            //        0,
            //        GLES30.GL_RGBA,
            //        GLES30.GL_UNSIGNED_BYTE,
            //        image.getBuffer());
            //GLError.maybeThrowGLException("Failed to update texture data", "glTexSubImage2D");
        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    public Texture getTexture() {
        return this.texture;
    }

    @Override
    public void close() {
        texture.close();
    }
}
